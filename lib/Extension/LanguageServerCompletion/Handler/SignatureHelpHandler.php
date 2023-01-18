<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCompletion\Handler;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\PositionConverter;
use Phpactor202301\Phpactor\LanguageServerProtocol\Position;
use Phpactor202301\Phpactor\LanguageServerProtocol\ServerCapabilities;
use Phpactor202301\Phpactor\LanguageServerProtocol\SignatureHelpOptions;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentIdentifier;
use Phpactor202301\Phpactor\Completion\Core\Exception\CouldNotHelpWithSignature;
use Phpactor202301\Phpactor\Completion\Core\SignatureHelper;
use Phpactor202301\Phpactor\Extension\LanguageServerCompletion\Util\PhpactorToLspSignature;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\CanRegisterCapabilities;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\Handler;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
class SignatureHelpHandler implements Handler, CanRegisterCapabilities
{
    public function __construct(private Workspace $workspace, private SignatureHelper $helper)
    {
    }
    public function methods() : array
    {
        return ['textDocument/signatureHelp' => 'signatureHelp'];
    }
    public function signatureHelp(TextDocumentIdentifier $textDocument, Position $position) : Promise
    {
        return \Phpactor202301\Amp\call(function () use($textDocument, $position) {
            $textDocument = $this->workspace->get($textDocument->uri);
            $languageId = $textDocument->languageId ?: 'php';
            try {
                return PhpactorToLspSignature::toLspSignatureHelp($this->helper->signatureHelp(TextDocumentBuilder::create($textDocument->text)->language($languageId)->uri($textDocument->uri)->build(), PositionConverter::positionToByteOffset($position, $textDocument->text)));
            } catch (CouldNotHelpWithSignature) {
                return null;
            }
        });
    }
    public function registerCapabiltiies(ServerCapabilities $capabilities) : void
    {
        $options = new SignatureHelpOptions();
        $options->triggerCharacters = ['(', ',', '@'];
        $capabilities->signatureHelpProvider = $options;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCompletion\\Handler\\SignatureHelpHandler', 'Phpactor\\Extension\\LanguageServerCompletion\\Handler\\SignatureHelpHandler', \false);
