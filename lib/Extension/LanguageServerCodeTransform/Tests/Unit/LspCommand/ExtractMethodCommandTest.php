<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Tests\Unit\LspCommand;

use Exception;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeTransform\Domain\Exception\TransformException;
use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\ExtractMethod;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\TextEditConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand\ExtractMethodCommand;
use Phpactor202301\Phpactor\LanguageServerProtocol\ApplyWorkspaceEditResponse;
use Phpactor202301\Phpactor\LanguageServerProtocol\MessageType;
use Phpactor202301\Phpactor\LanguageServerProtocol\WorkspaceEdit;
use Phpactor202301\Phpactor\LanguageServer\LanguageServerTesterBuilder;
use Phpactor202301\Phpactor\TextDocument\TextDocumentEdits;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
use Phpactor202301\Phpactor\TextDocument\TextEdit;
use Phpactor202301\Prophecy\Argument;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
class ExtractMethodCommandTest extends TestCase
{
    use ProphecyTrait;
    const EXAMPLE_SOURCE = '<?php ';
    const EXAMPLE_URI = 'file:///file.php';
    const EXAMPLE_OFFSET = 5;
    public function testSuccessfulCall() : void
    {
        $textEdits = new TextDocumentEdits(TextDocumentUri::fromString(self::EXAMPLE_URI), new TextEdits(TextEdit::create(self::EXAMPLE_OFFSET, 1, 'test')));
        $extractMethod = $this->prophesize(ExtractMethod::class);
        $extractMethod->extractMethod(Argument::type(SourceCode::class), 0, self::EXAMPLE_OFFSET, ExtractMethodCommand::DEFAULT_METHOD_NAME)->shouldBeCalled()->willReturn($textEdits);
        [$tester, $builder] = $this->createTester($extractMethod);
        $tester->workspace()->executeCommand('extract_method', [self::EXAMPLE_URI, 0, self::EXAMPLE_OFFSET]);
        $builder->responseWatcher()->resolveLastResponse(new ApplyWorkspaceEditResponse(\true));
        $applyEdit = $builder->transmitter()->filterByMethod('workspace/applyEdit')->shiftRequest();
        self::assertNotNull($applyEdit);
        self::assertEquals(['edit' => new WorkspaceEdit([(string) $textEdits->uri() => TextEditConverter::toLspTextEdits($textEdits->textEdits(), self::EXAMPLE_SOURCE)]), 'label' => 'Extract method'], $applyEdit->params);
    }
    /**
     * @dataProvider provideExceptions
     */
    public function testFailedCall(Exception $exception) : void
    {
        $extractMethod = $this->prophesize(ExtractMethod::class);
        $extractMethod->extractMethod(Argument::type(SourceCode::class), 0, self::EXAMPLE_OFFSET, ExtractMethodCommand::DEFAULT_METHOD_NAME)->shouldBeCalled()->willThrow($exception);
        [$tester, $builder] = $this->createTester($extractMethod);
        $tester->workspace()->executeCommand('extract_method', [self::EXAMPLE_URI, 0, self::EXAMPLE_OFFSET]);
        $showMessage = $builder->transmitter()->filterByMethod('window/showMessage')->shiftNotification();
        self::assertNotNull($showMessage);
        self::assertEquals(['type' => MessageType::WARNING, 'message' => $exception->getMessage()], $showMessage->params);
    }
    public function provideExceptions() : array
    {
        return [TransformException::class => [new TransformException('Error message!')]];
    }
    private function createTester(ObjectProphecy $extractMethod) : array
    {
        $builder = LanguageServerTesterBuilder::createBare()->enableTextDocuments()->enableCommands();
        $builder->addCommand('extract_method', new ExtractMethodCommand($builder->clientApi(), $builder->workspace(), $extractMethod->reveal()));
        $tester = $builder->build();
        $tester->textDocument()->open(self::EXAMPLE_URI, self::EXAMPLE_SOURCE);
        return [$tester, $builder];
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\LspCommand\\ExtractMethodCommandTest', 'Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\LspCommand\\ExtractMethodCommandTest', \false);
