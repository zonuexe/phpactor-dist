<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerSymbolProvider\Handler;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor202301\Phpactor\Extension\LanguageServerSymbolProvider\Model\DocumentSymbolProvider;
use Phpactor202301\Phpactor\LanguageServerProtocol\DocumentSymbolParams;
use Phpactor202301\Phpactor\LanguageServerProtocol\DocumentSymbolRequest;
use Phpactor202301\Phpactor\LanguageServerProtocol\ServerCapabilities;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\CanRegisterCapabilities;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\Handler;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
class DocumentSymbolProviderHandler implements Handler, CanRegisterCapabilities
{
    public function __construct(private Workspace $workspace, private DocumentSymbolProvider $provider)
    {
    }
    public function methods() : array
    {
        return [DocumentSymbolRequest::METHOD => 'documentSymbols'];
    }
    /**
     * @return Promise<array>
     */
    public function documentSymbols(DocumentSymbolParams $params) : Promise
    {
        $textDocument = $this->workspace->get($params->textDocument->uri);
        return new Success($this->provider->provideFor($textDocument->text));
    }
    public function registerCapabiltiies(ServerCapabilities $capabilities) : void
    {
        $capabilities->documentSymbolProvider = \true;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerSymbolProvider\\Handler\\DocumentSymbolProviderHandler', 'Phpactor\\Extension\\LanguageServerSymbolProvider\\Handler\\DocumentSymbolProviderHandler', \false);
