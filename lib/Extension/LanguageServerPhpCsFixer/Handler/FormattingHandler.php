<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerPhpCsFixer\Handler;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\Extension\LanguageServerPhpCsFixer\Formatter\PhpCsFixerFormatter;
use Phpactor202301\Phpactor\LanguageServerProtocol\FormattingOptions;
use Phpactor202301\Phpactor\LanguageServerProtocol\ServerCapabilities;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentIdentifier;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextEdit;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\CanRegisterCapabilities;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\Handler;
use Phpactor202301\Phpactor\TextDocument\TextDocumentLocator;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use function Phpactor202301\Amp\call;
class FormattingHandler implements Handler, CanRegisterCapabilities
{
    public function __construct(private PhpCsFixerFormatter $formatter, private TextDocumentLocator $locator)
    {
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
            $document = $this->locator->get(TextDocumentUri::fromString($textDocument->uri));
            $formatted = (yield $this->formatter->format($document));
            return $formatted;
        });
    }
    public function registerCapabiltiies(ServerCapabilities $capabilities) : void
    {
        $capabilities->documentFormattingProvider = \true;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerPhpCsFixer\\Handler\\FormattingHandler', 'Phpactor\\Extension\\LanguageServerPhpCsFixer\\Handler\\FormattingHandler', \false);
