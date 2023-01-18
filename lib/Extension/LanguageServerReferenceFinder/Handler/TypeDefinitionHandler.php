<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerReferenceFinder\Handler;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\PositionConverter;
use Phpactor202301\Phpactor\LanguageServerProtocol\Location;
use Phpactor202301\Phpactor\LanguageServerProtocol\MessageActionItem;
use Phpactor202301\Phpactor\LanguageServerProtocol\Position;
use Phpactor202301\Phpactor\LanguageServerProtocol\ServerCapabilities;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentIdentifier;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\LocationConverter;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\CanRegisterCapabilities;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\Handler;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
use Phpactor202301\Phpactor\ReferenceFinder\Exception\CouldNotLocateType;
use Phpactor202301\Phpactor\ReferenceFinder\TypeLocator;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
class TypeDefinitionHandler implements Handler, CanRegisterCapabilities
{
    public function __construct(private Workspace $workspace, private TypeLocator $typeLocator, private LocationConverter $locationConverter, private ClientApi $client)
    {
    }
    /**
     * @return array<string,string>
     */
    public function methods() : array
    {
        return ['textDocument/typeDefinition' => 'type'];
    }
    /**
     * @return Promise<Location>
     */
    public function type(TextDocumentIdentifier $textDocument, Position $position) : Promise
    {
        return \Phpactor202301\Amp\call(function () use($textDocument, $position) {
            $textDocument = $this->workspace->get($textDocument->uri);
            $offset = PositionConverter::positionToByteOffset($position, $textDocument->text);
            try {
                $typeLocations = $this->typeLocator->locateTypes(TextDocumentBuilder::create($textDocument->text)->uri($textDocument->uri)->language('php')->build(), $offset);
            } catch (CouldNotLocateType) {
                return null;
            }
            if ($typeLocations->count() === 1) {
                return $this->locationConverter->toLspLocation($typeLocations->first()->location());
            }
            $actions = [];
            foreach ($typeLocations as $typeLocation) {
                $actions[] = new MessageActionItem(\sprintf('%s', $typeLocation->type()->__toString()));
            }
            $item = (yield $this->client->window()->showMessageRequest()->info('Goto type', ...$actions));
            if (!$item instanceof MessageActionItem) {
                throw new CouldNotLocateType('Client did not return an action item');
            }
            return $this->locationConverter->toLspLocation($typeLocations->byTypeName($item->title)->location());
        });
    }
    public function registerCapabiltiies(ServerCapabilities $capabilities) : void
    {
        $capabilities->typeDefinitionProvider = \true;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerReferenceFinder\\Handler\\TypeDefinitionHandler', 'Phpactor\\Extension\\LanguageServerReferenceFinder\\Handler\\TypeDefinitionHandler', \false);
