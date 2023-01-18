<?php

namespace Phpactor202301\Phpactor\LanguageServer\Handler\TextDocument;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServerProtocol\CodeAction;
use Phpactor202301\Phpactor\LanguageServerProtocol\CodeActionOptions;
use Phpactor202301\Phpactor\LanguageServerProtocol\CodeActionParams;
use Phpactor202301\Phpactor\LanguageServerProtocol\CodeActionRequest;
use Phpactor202301\Phpactor\LanguageServerProtocol\ServerCapabilities;
use Phpactor202301\Phpactor\LanguageServer\Core\CodeAction\CodeActionProvider;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\CanRegisterCapabilities;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\Handler;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
use function Phpactor202301\Amp\call;
class CodeActionHandler implements Handler, CanRegisterCapabilities
{
    /**
     * @var CodeActionProvider
     */
    private $provider;
    /**
     * @var Workspace
     */
    private $workspace;
    public function __construct(CodeActionProvider $provider, Workspace $workspace)
    {
        $this->provider = $provider;
        $this->workspace = $workspace;
    }
    /**
     * {@inheritDoc}
     */
    public function methods() : array
    {
        return [CodeActionRequest::METHOD => 'codeAction'];
    }
    public function registerCapabiltiies(ServerCapabilities $capabilities) : void
    {
        $options = new CodeActionOptions($this->provider->kinds());
        $capabilities->codeActionProvider = $options;
    }
    /**
     * @return Promise<array<CodeAction>>
     */
    public function codeAction(CodeActionParams $params, CancellationToken $cancel) : Promise
    {
        return call(function () use($params, $cancel) {
            $document = $this->workspace->get($params->textDocument->uri);
            return $this->provider->provideActionsFor($document, $params->range, $cancel);
        });
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Handler\\TextDocument\\CodeActionHandler', 'Phpactor\\LanguageServer\\Handler\\TextDocument\\CodeActionHandler', \false);
