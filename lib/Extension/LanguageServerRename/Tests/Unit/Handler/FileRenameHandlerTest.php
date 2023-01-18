<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerRename\Tests\Unit\Handler;

use Phpactor202301\Phpactor\Extension\LanguageServerBridge\TextDocument\WorkspaceTextDocumentLocator;
use Phpactor202301\Phpactor\Extension\LanguageServerRename\Handler\FileRenameHandler;
use Phpactor202301\Phpactor\Rename\Model\FileRenamer\TestFileRenamer;
use Phpactor202301\Phpactor\Rename\Model\LocatedTextEditsMap;
use Phpactor202301\Phpactor\Extension\LanguageServerRename\Tests\IntegrationTestCase;
use Phpactor202301\Phpactor\Extension\LanguageServerRename\Util\LocatedTextEditConverter;
use Phpactor202301\Phpactor\LanguageServerProtocol\FileOperationRegistrationOptions;
use Phpactor202301\Phpactor\LanguageServerProtocol\FileRename;
use Phpactor202301\Phpactor\LanguageServerProtocol\RenameFilesParams;
use Phpactor202301\Phpactor\LanguageServerProtocol\WorkspaceEdit;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\ResponseMessage;
use Phpactor202301\Phpactor\LanguageServer\LanguageServerTesterBuilder;
use Phpactor202301\Phpactor\LanguageServer\Test\LanguageServerTester;
use Phpactor202301\Phpactor\TextDocument\TextEdit;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
use function Phpactor202301\Amp\Promise\wait;
class FileRenameHandlerTest extends IntegrationTestCase
{
    public function testCapabilities() : void
    {
        $server = $this->createServer();
        $result = $server->initialize();
        self::assertInstanceOf(FileOperationRegistrationOptions::class, $result->capabilities->workspace['fileOperations']['willRename']);
    }
    public function testMoveFileNoEdits() : void
    {
        $server = $this->createServer();
        $server->initialize();
        $response = wait($server->request('workspace/willRenameFiles', new RenameFilesParams([new FileRename('file:///file1', 'file:///file2')])));
        \assert($response instanceof ResponseMessage);
        self::assertInstanceOf(WorkspaceEdit::class, $response->result);
    }
    public function testMoveFileEdits() : void
    {
        $server = $this->createServer(\false, ['file:///file1' => TextEdits::one(TextEdit::create(0, 0, 'Hello')), 'file:///file2' => TextEdits::one(TextEdit::create(0, 0, 'Hello'))]);
        $server->initialize();
        $response = wait($server->request('workspace/willRenameFiles', new RenameFilesParams([new FileRename('file:///file1', 'file:///file2')])));
        \assert($response instanceof ResponseMessage);
        $edits = $response->result;
        self::assertInstanceOf(WorkspaceEdit::class, $edits);
        \assert($edits instanceof WorkspaceEdit);
        self::assertCount(2, $edits->documentChanges);
    }
    private function createServer(bool $willFail = \false, array $workspaceEdits = []) : LanguageServerTester
    {
        $builder = LanguageServerTesterBuilder::createBare()->enableTextDocuments()->enableFileEvents();
        $builder->addHandler($this->createHandler($builder, $willFail, $workspaceEdits));
        $server = $builder->build();
        foreach ($workspaceEdits as $path => $_) {
            $server->textDocument()->open($path, '');
        }
        return $server;
    }
    private function createHandler(LanguageServerTesterBuilder $builder, bool $willError = \false, array $workspaceEdits = []) : FileRenameHandler
    {
        return new FileRenameHandler(new TestFileRenamer($willError, new LocatedTextEditsMap($workspaceEdits)), new LocatedTextEditConverter($builder->workspace(), new WorkspaceTextDocumentLocator($builder->workspace())));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerRename\\Tests\\Unit\\Handler\\FileRenameHandlerTest', 'Phpactor\\Extension\\LanguageServerRename\\Tests\\Unit\\Handler\\FileRenameHandlerTest', \false);
