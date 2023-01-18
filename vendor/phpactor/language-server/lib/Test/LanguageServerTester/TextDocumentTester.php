<?php

namespace Phpactor202301\Phpactor\LanguageServer\Test\LanguageServerTester;

use Phpactor202301\Phpactor\LanguageServerProtocol\DidChangeTextDocumentNotification;
use Phpactor202301\Phpactor\LanguageServerProtocol\DidChangeTextDocumentParams;
use Phpactor202301\Phpactor\LanguageServerProtocol\DidSaveTextDocumentNotification;
use Phpactor202301\Phpactor\LanguageServerProtocol\DidSaveTextDocumentParams;
use Phpactor202301\Phpactor\LanguageServer\Test\ProtocolFactory;
use Phpactor202301\Phpactor\LanguageServerProtocol\DidOpenTextDocumentParams;
use Phpactor202301\Phpactor\LanguageServerProtocol\DidOpenTextDocumentNotification;
use Phpactor202301\Phpactor\LanguageServer\Test\LanguageServerTester;
class TextDocumentTester
{
    /**
     * @var LanguageServerTester
     */
    private $tester;
    public function __construct(LanguageServerTester $tester)
    {
        $this->tester = $tester;
    }
    public function open(string $url, string $content) : void
    {
        $this->tester->notifyAndWait(DidOpenTextDocumentNotification::METHOD, new DidOpenTextDocumentParams(ProtocolFactory::textDocumentItem($url, $content)));
    }
    public function update(string $uri, string $newText) : void
    {
        $this->tester->notifyAndWait(DidChangeTextDocumentNotification::METHOD, new DidChangeTextDocumentParams(ProtocolFactory::versionedTextDocumentIdentifier($uri, 1), [['text' => $newText]]));
    }
    public function save(string $uri) : void
    {
        $this->tester->notifyAndWait(DidSaveTextDocumentNotification::METHOD, new DidSaveTextDocumentParams(ProtocolFactory::versionedTextDocumentIdentifier($uri, 1)));
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Test\\LanguageServerTester\\TextDocumentTester', 'Phpactor\\LanguageServer\\Test\\LanguageServerTester\\TextDocumentTester', \false);
