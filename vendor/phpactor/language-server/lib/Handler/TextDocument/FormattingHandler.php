<?php

namespace Phpactor202301\Phpactor\LanguageServer\Handler\TextDocument;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServerProtocol\FormattingOptions;
use Phpactor202301\Phpactor\LanguageServerProtocol\ServerCapabilities;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentIdentifier;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextEdit;
use Phpactor202301\Phpactor\LanguageServer\Core\Formatting\Formatter;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\CanRegisterCapabilities;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\Handler;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
use function Phpactor202301\Amp\call;
class FormattingHandler implements Handler, CanRegisterCapabilities
{
    private Workspace $workspace;
    private Formatter $formatter;
    public function __construct(Workspace $workspace, Formatter $formatter)
    {
        $this->workspace = $workspace;
        $this->formatter = $formatter;
    }
    public function methods() : array
    {
        return ['textDocument/formatting' => 'formatting'];
    }
    /**
     * @return Promise<array<int,TextEdit[]>|null>
     */
    public function formatting(TextDocumentIdentifier $textDocument, FormattingOptions $options) : Promise
    {
        return call(function () use($textDocument) {
            $document = $this->workspace->get($textDocument->uri);
            $formatted = (yield $this->formatter->format($document));
            return $formatted;
        });
    }
    public function registerCapabiltiies(ServerCapabilities $capabilities) : void
    {
        $capabilities->documentFormattingProvider = \true;
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Handler\\TextDocument\\FormattingHandler', 'Phpactor\\LanguageServer\\Handler\\TextDocument\\FormattingHandler', \false);
