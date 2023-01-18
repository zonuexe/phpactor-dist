<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerIndexer\Handler;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\Extension\LanguageServerIndexer\Model\WorkspaceSymbolProvider;
use Phpactor202301\Phpactor\LanguageServerProtocol\ServerCapabilities;
use Phpactor202301\Phpactor\LanguageServerProtocol\SymbolInformation;
use Phpactor202301\Phpactor\LanguageServerProtocol\WorkspaceSymbolParams;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\CanRegisterCapabilities;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\Handler;
class WorkspaceSymbolHandler implements Handler, CanRegisterCapabilities
{
    public function __construct(private WorkspaceSymbolProvider $provider)
    {
    }
    public function methods() : array
    {
        return ['workspace/symbol' => 'symbol'];
    }
    /**
     * @return Promise<SymbolInformation[]>
     */
    public function symbol(WorkspaceSymbolParams $params) : Promise
    {
        return \Phpactor202301\Amp\call(function () use($params) {
            return $this->provider->provideFor($params->query);
        });
    }
    public function registerCapabiltiies(ServerCapabilities $capabilities) : void
    {
        $capabilities->workspaceSymbolProvider = \true;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerIndexer\\Handler\\WorkspaceSymbolHandler', 'Phpactor\\Extension\\LanguageServerIndexer\\Handler\\WorkspaceSymbolHandler', \false);
