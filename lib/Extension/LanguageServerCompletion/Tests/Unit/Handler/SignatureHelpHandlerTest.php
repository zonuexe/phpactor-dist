<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCompletion\Tests\Unit\Handler;

use Phpactor202301\Phpactor\LanguageServerProtocol\SignatureHelp as LspSignatureHelp;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentIdentifier;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Completion\Core\SignatureHelp;
use Phpactor202301\Phpactor\Completion\Core\SignatureHelper;
use Phpactor202301\Phpactor\Extension\LanguageServerCompletion\Handler\SignatureHelpHandler;
use Phpactor202301\Phpactor\LanguageServer\LanguageServerTesterBuilder;
use Phpactor202301\Phpactor\LanguageServer\Test\LanguageServerTester;
use Phpactor202301\Phpactor\LanguageServer\Test\ProtocolFactory;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
class SignatureHelpHandlerTest extends TestCase
{
    const IDENTIFIER = '/test';
    public function testHandleHelpers() : void
    {
        $tester = $this->create([]);
        $tester->textDocument()->open(self::IDENTIFIER, 'hello');
        $response = $tester->requestAndWait('textDocument/signatureHelp', ['textDocument' => new TextDocumentIdentifier(self::IDENTIFIER), 'position' => ProtocolFactory::position(0, 0)]);
        $list = $response->result;
        $this->assertInstanceOf(LspSignatureHelp::class, $list);
    }
    private function create(array $suggestions) : LanguageServerTester
    {
        $builder = LanguageServerTesterBuilder::create();
        return $builder->addHandler(new SignatureHelpHandler($builder->workspace(), $this->createHelper()))->build();
    }
    private function createHelper() : SignatureHelper
    {
        return new class implements SignatureHelper
        {
            public function signatureHelp(TextDocument $textDocument, ByteOffset $offset) : SignatureHelp
            {
                $help = new SignatureHelp([], 0);
                return $help;
            }
        };
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCompletion\\Tests\\Unit\\Handler\\SignatureHelpHandlerTest', 'Phpactor\\Extension\\LanguageServerCompletion\\Tests\\Unit\\Handler\\SignatureHelpHandlerTest', \false);
