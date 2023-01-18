<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Tests\Unit\LspCommand;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\CodeTransform\Domain\Exception\TransformException;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand\ImportNameCommand;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Model\NameImport\NameImporterResult;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Model\NameImport\NameImporter;
use Phpactor202301\Phpactor\LanguageServer\Core\Command\CommandDispatcher;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\RpcClient\TestRpcClient;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
use Phpactor202301\Phpactor\LanguageServerProtocol\ApplyWorkspaceEditResponse;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextEdit;
use Phpactor202301\Phpactor\TestUtils\PHPUnit\TestCase;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
class ImportNameCommandTest extends TestCase
{
    const EXAMPLE_CONTENT = 'hello this is some text';
    const EXAMPLE_PATH = '/foobar.php';
    const EXAMPLE_OFFSET = 12;
    const EXAMPLE_PATH_URI = 'file:///foobar.php';
    private Workspace $workspace;
    private TestRpcClient $rpcClient;
    private ImportNameCommand $command;
    /**
     * @var ObjectProphecy<TextEdit>
     */
    private ObjectProphecy $textEditProphecy;
    /**
     * @var ObjectProphecy<NameImporter>
     */
    private ObjectProphecy $nameImporterProphecy;
    protected function setUp() : void
    {
        $this->textEditProphecy = $this->prophesize(TextEdit::class);
        $this->nameImporterProphecy = $this->prophesize(NameImporter::class);
        $this->workspace = new Workspace();
        $this->rpcClient = TestRpcClient::create();
        $this->command = new ImportNameCommand($this->nameImporterProphecy->reveal(), $this->workspace, new ClientApi($this->rpcClient));
    }
    public function testImportClass() : void
    {
        $textDoc = new TextDocumentItem(self::EXAMPLE_PATH_URI, 'php', 1, self::EXAMPLE_CONTENT);
        $this->workspace->open($textDoc);
        $this->nameImporterProphecy->__invoke($textDoc, self::EXAMPLE_OFFSET, 'class', 'Foobar', \true, null)->willReturn(NameImporterResult::createResult(\Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\ImportClass\NameImport::forClass('Foobar'), [$this->textEditProphecy->reveal()]));
        $promise = (new CommandDispatcher([ImportNameCommand::NAME => $this->command]))->dispatch(ImportNameCommand::NAME, [self::EXAMPLE_PATH_URI, self::EXAMPLE_OFFSET, 'class', 'Foobar']);
        $this->assertWorkspaceResponse($promise);
    }
    public function testNotifyOnError() : void
    {
        $textDoc = new TextDocumentItem(self::EXAMPLE_PATH_URI, 'php', 1, self::EXAMPLE_CONTENT);
        $this->workspace->open($textDoc);
        $this->nameImporterProphecy->__invoke($textDoc, self::EXAMPLE_OFFSET, 'class', 'Foobar', \true, null)->willReturn(NameImporterResult::createErrorResult(new TransformException('Sorry')));
        (new CommandDispatcher([ImportNameCommand::NAME => $this->command]))->dispatch(ImportNameCommand::NAME, [self::EXAMPLE_PATH_URI, self::EXAMPLE_OFFSET, 'class', 'Foobar']);
        self::assertNotNull($message = $this->rpcClient->transmitter()->shiftNotification());
        self::assertEquals('Sorry', $message->params['message']);
    }
    private function assertWorkspaceResponse(Promise $promise) : void
    {
        $expectedResponse = new ApplyWorkspaceEditResponse(\true, null);
        $this->rpcClient->responseWatcher()->resolveLastResponse($expectedResponse);
        $result = \Phpactor202301\Amp\Promise\wait($promise);
        $this->assertEquals($expectedResponse, $result);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\LspCommand\\ImportNameCommandTest', 'Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\LspCommand\\ImportNameCommandTest', \false);
