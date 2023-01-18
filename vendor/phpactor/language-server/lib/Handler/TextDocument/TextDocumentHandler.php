<?php

namespace Phpactor202301\Phpactor\LanguageServer\Handler\TextDocument;

use Phpactor202301\Phpactor\LanguageServerProtocol\DidChangeTextDocumentParams;
use Phpactor202301\Phpactor\LanguageServerProtocol\DidCloseTextDocumentParams;
use Phpactor202301\Phpactor\LanguageServerProtocol\DidOpenTextDocumentParams;
use Phpactor202301\Phpactor\LanguageServerProtocol\DidSaveTextDocumentParams;
use Phpactor202301\Phpactor\LanguageServerProtocol\ServerCapabilities;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentSyncKind;
use Phpactor202301\Phpactor\LanguageServerProtocol\WillSaveTextDocumentParams;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\CanRegisterCapabilities;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\Handler;
use Phpactor202301\Phpactor\LanguageServer\Event\TextDocumentClosed;
use Phpactor202301\Phpactor\LanguageServer\Event\TextDocumentOpened;
use Phpactor202301\Phpactor\LanguageServer\Event\TextDocumentSaved;
use Phpactor202301\Phpactor\LanguageServer\Event\TextDocumentUpdated;
use Phpactor202301\Psr\EventDispatcher\EventDispatcherInterface;
final class TextDocumentHandler implements Handler, CanRegisterCapabilities
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
    public function methods() : array
    {
        return ['textDocument/didOpen' => 'didOpen', 'textDocument/didChange' => 'didChange', 'textDocument/didClose' => 'didClose', 'textDocument/didSave' => 'didSave', 'textDocument/willSave' => 'willSave', 'textDocument/willSaveWaitUntil' => 'willSaveWaitUntil'];
    }
    public function didOpen(DidOpenTextDocumentParams $params) : void
    {
        $this->dispatcher->dispatch(new TextDocumentOpened($params->textDocument));
    }
    public function didChange(DidChangeTextDocumentParams $params) : void
    {
        foreach ($params->contentChanges as $contentChange) {
            $this->dispatcher->dispatch(new TextDocumentUpdated($params->textDocument, $contentChange['text']));
        }
    }
    public function didClose(DidCloseTextDocumentParams $params) : void
    {
        $this->dispatcher->dispatch(new TextDocumentClosed($params->textDocument));
    }
    public function didSave(DidSaveTextDocumentParams $params) : void
    {
        $this->dispatcher->dispatch(new TextDocumentSaved($params->textDocument, $params->text));
    }
    public function willSave(WillSaveTextDocumentParams $params) : void
    {
    }
    public function willSaveWaitUntil(WillSaveTextDocumentParams $params) : void
    {
    }
    public function registerCapabiltiies(ServerCapabilities $capabilities) : void
    {
        $capabilities->textDocumentSync = TextDocumentSyncKind::FULL;
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Handler\\TextDocument\\TextDocumentHandler', 'Phpactor\\LanguageServer\\Handler\\TextDocument\\TextDocumentHandler', \false);
