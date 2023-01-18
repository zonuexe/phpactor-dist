<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerReferenceFinder\Handler;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\PositionConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerReferenceFinder\Model\Highlighter;
use Phpactor202301\Phpactor\LanguageServerProtocol\DocumentHighlight;
use Phpactor202301\Phpactor\LanguageServerProtocol\DocumentHighlightParams;
use Phpactor202301\Phpactor\LanguageServerProtocol\DocumentHighlightRequest;
use Phpactor202301\Phpactor\LanguageServerProtocol\ServerCapabilities;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\CanRegisterCapabilities;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\Handler;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
class HighlightHandler implements Handler, CanRegisterCapabilities
{
    public function __construct(private Workspace $workspace, private Highlighter $highlighter)
    {
    }
    public function methods() : array
    {
        return [DocumentHighlightRequest::METHOD => 'highlight'];
    }
    /**
     * @return Promise<array<DocumentHighlight>|null>
     */
    public function highlight(DocumentHighlightParams $params) : Promise
    {
        $textDocument = $this->workspace->get($params->textDocument->uri);
        $offset = PositionConverter::positionToByteOffset($params->position, $textDocument->text);
        return new Success($this->highlighter->highlightsFor($textDocument->text, $offset)->toArray());
    }
    public function registerCapabiltiies(ServerCapabilities $capabilities) : void
    {
        $capabilities->documentHighlightProvider = \true;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerReferenceFinder\\Handler\\HighlightHandler', 'Phpactor\\Extension\\LanguageServerReferenceFinder\\Handler\\HighlightHandler', \false);
