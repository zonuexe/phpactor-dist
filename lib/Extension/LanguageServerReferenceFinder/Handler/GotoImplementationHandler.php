<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerReferenceFinder\Handler;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\PositionConverter;
use Phpactor202301\Phpactor\LanguageServerProtocol\ImplementationParams;
use Phpactor202301\Phpactor\LanguageServerProtocol\ServerCapabilities;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\LocationConverter;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\CanRegisterCapabilities;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\Handler;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
use Phpactor202301\Phpactor\ReferenceFinder\ClassImplementationFinder;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
class GotoImplementationHandler implements Handler, CanRegisterCapabilities
{
    public function __construct(private Workspace $workspace, private ClassImplementationFinder $finder, private LocationConverter $locationConverter)
    {
    }
    public function methods() : array
    {
        return ['textDocument/implementation' => 'gotoImplementation'];
    }
    public function gotoImplementation(ImplementationParams $params) : Promise
    {
        return \Phpactor202301\Amp\call(function () use($params) {
            $textDocument = $this->workspace->get($params->textDocument->uri);
            $phpactorDocument = TextDocumentBuilder::create($textDocument->text)->uri($textDocument->uri)->language($textDocument->languageId ?? 'php')->build();
            $offset = PositionConverter::positionToByteOffset($params->position, $textDocument->text);
            $locations = $this->finder->findImplementations($phpactorDocument, $offset);
            return $this->locationConverter->toLspLocations($locations);
        });
    }
    public function registerCapabiltiies(ServerCapabilities $capabilities) : void
    {
        $capabilities->implementationProvider = \true;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerReferenceFinder\\Handler\\GotoImplementationHandler', 'Phpactor\\Extension\\LanguageServerReferenceFinder\\Handler\\GotoImplementationHandler', \false);