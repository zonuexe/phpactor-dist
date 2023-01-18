<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerReferenceFinder\Handler;

use Phpactor202301\Amp\Delayed;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\PositionConverter;
use Phpactor202301\Phpactor\LanguageServerProtocol\Location as LspLocation;
use Phpactor202301\Phpactor\LanguageServerProtocol\Position;
use Phpactor202301\Phpactor\LanguageServerProtocol\ReferenceContext;
use Phpactor202301\Phpactor\LanguageServerProtocol\ServerCapabilities;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentIdentifier;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\LocationConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerReferenceFinder\LanguageServerReferenceFinderExtension;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\CanRegisterCapabilities;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\Handler;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
use Phpactor202301\Phpactor\ReferenceFinder\DefinitionLocator;
use Phpactor202301\Phpactor\ReferenceFinder\Exception\CouldNotLocateDefinition;
use Phpactor202301\Phpactor\ReferenceFinder\ReferenceFinder;
use Phpactor202301\Phpactor\TextDocument\Location;
use Phpactor202301\Phpactor\TextDocument\Locations;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
class ReferencesHandler implements Handler, CanRegisterCapabilities
{
    public function __construct(private Workspace $workspace, private ReferenceFinder $finder, private DefinitionLocator $definitionLocator, private LocationConverter $locationConverter, private ClientApi $clientApi, private float $timeoutSeconds = 5.0)
    {
    }
    public function methods() : array
    {
        return ['textDocument/references' => 'references'];
    }
    public function references(TextDocumentIdentifier $textDocument, Position $position, ReferenceContext $context) : Promise
    {
        return \Phpactor202301\Amp\call(function () use($textDocument, $position, $context) {
            $textDocument = $this->workspace->get($textDocument->uri);
            $phpactorDocument = TextDocumentBuilder::create($textDocument->text)->uri($textDocument->uri)->language($textDocument->languageId ?? 'php')->build();
            $offset = PositionConverter::positionToByteOffset($position, $textDocument->text);
            $locations = [];
            if ($context->includeDeclaration) {
                try {
                    $potentialLocation = $this->definitionLocator->locateDefinition($phpactorDocument, $offset)->first()->location();
                    $locations[] = new Location($potentialLocation->uri(), $potentialLocation->offset());
                } catch (CouldNotLocateDefinition) {
                }
            }
            $start = \microtime(\true);
            $count = 0;
            $risky = 0;
            foreach ($this->finder->findReferences($phpactorDocument, $offset) as $potentialLocation) {
                if ($potentialLocation->isSurely()) {
                    $locations[] = $potentialLocation->location();
                }
                if ($potentialLocation->isMaybe()) {
                    $risky++;
                }
                if ($count++ % 100 === 0) {
                    $this->clientApi->window()->showMessage()->info(\sprintf('... scanned %s references confirmed %s ...', $count - 1, \count($locations)));
                }
                if (\microtime(\true) - $start > $this->timeoutSeconds) {
                    $this->clientApi->window()->showMessage()->info(\sprintf('Reference find stopped, %s/%s references confirmed but took too long (%s/%s seconds). Adjust `%s`', \count($locations), $count, \number_format(\microtime(\true) - $start, 2), $this->timeoutSeconds, LanguageServerReferenceFinderExtension::PARAM_REFERENCE_TIMEOUT));
                    return $this->toLocations($locations);
                }
                if ($count % 10) {
                    // give other co-routines a chance
                    (yield new Delayed(0));
                }
            }
            $this->clientApi->window()->showMessage()->info(\sprintf('Found %s reference(s)%s', \count($locations), $risky ? \sprintf(' %s unresolvable references excluded', $risky) : ''));
            return $this->toLocations($locations);
        });
    }
    public function registerCapabiltiies(ServerCapabilities $capabilities) : void
    {
        $capabilities->referencesProvider = \true;
    }
    /**
     * @param Location[] $locations
     * @return LspLocation[]
     */
    private function toLocations(array $locations) : array
    {
        return $this->locationConverter->toLspLocations((new Locations($locations))->sorted());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerReferenceFinder\\Handler\\ReferencesHandler', 'Phpactor\\Extension\\LanguageServerReferenceFinder\\Handler\\ReferencesHandler', \false);
