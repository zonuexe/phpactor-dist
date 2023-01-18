<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Tests\Unit\LspCommand;

use Phpactor202301\Phpactor\LanguageServerProtocol\ApplyWorkspaceEditResponse;
use Phpactor202301\Phpactor\LanguageServerProtocol\MessageType;
use Phpactor202301\Phpactor\LanguageServer\LanguageServerTesterBuilder;
use Phpactor202301\Phpactor\LanguageServer\Test\LanguageServerTester;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
use Phpactor202301\Phpactor\TextDocument\TextDocumentLocator\InMemoryDocumentLocator;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\CouldNotResolveNode;
use Phpactor202301\Phpactor\CodeTransform\Domain\Exception\TransformException;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\MethodCallNotFound;
use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\GenerateMethod;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\TextEditConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand\GenerateMethodCommand;
use Phpactor202301\Phpactor\LanguageServerProtocol\WorkspaceEdit;
use Phpactor202301\Phpactor\TextDocument\TextDocumentEdits;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use Phpactor202301\Phpactor\TextDocument\TextEdit;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Prophecy\Argument;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use Exception;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
class GenerateMethodCommandTest extends TestCase
{
    use ProphecyTrait;
    const EXAMPLE_SOURCE = '<?php ';
    const EXAMPLE_URI = 'file:///file.php';
    const EXAMPLE_OFFSET = 5;
    public function testSuccessfulCall() : void
    {
        $textEdits = new TextDocumentEdits(TextDocumentUri::fromString(self::EXAMPLE_URI), new TextEdits(TextEdit::create(self::EXAMPLE_OFFSET, 1, 'test')));
        $generateMethod = $this->prophesize(GenerateMethod::class);
        $generateMethod->generateMethod(Argument::type(SourceCode::class), self::EXAMPLE_OFFSET)->shouldBeCalled()->willReturn($textEdits);
        [$tester, $builder] = $this->createTester($generateMethod);
        $tester->workspace()->executeCommand('generate', [self::EXAMPLE_URI, self::EXAMPLE_OFFSET]);
        $builder->responseWatcher()->resolveLastResponse(new ApplyWorkspaceEditResponse(\true));
        $applyEdit = $builder->transmitter()->filterByMethod('workspace/applyEdit')->shiftRequest();
        self::assertNotNull($applyEdit);
        self::assertEquals(['edit' => new WorkspaceEdit([$textEdits->uri()->__toString() => TextEditConverter::toLspTextEdits($textEdits->textEdits(), self::EXAMPLE_SOURCE)]), 'label' => 'Generate method'], $applyEdit->params);
    }
    /**
     * @dataProvider provideExceptions
     */
    public function testFailedCall(Exception $exception) : void
    {
        $generateMethod = $this->prophesize(GenerateMethod::class);
        $generateMethod->generateMethod(Argument::type(SourceCode::class), self::EXAMPLE_OFFSET)->shouldBeCalled()->willThrow($exception);
        [$tester, $builder] = $this->createTester($generateMethod);
        $tester->workspace()->executeCommand('generate', [self::EXAMPLE_URI, self::EXAMPLE_OFFSET]);
        $showMessage = $builder->transmitter()->filterByMethod('window/showMessage')->shiftNotification();
        self::assertNotNull($showMessage);
        self::assertEquals(['type' => MessageType::WARNING, 'message' => $exception->getMessage()], $showMessage->params);
    }
    public function provideExceptions() : array
    {
        return [TransformException::class => [new TransformException('Error message!')], MethodCallNotFound::class => [new MethodCallNotFound('Error message!')], CouldNotResolveNode::class => [new CouldNotResolveNode('Error message!')]];
    }
    /**
     * @return {LanguageServerTester,LanguageServerTesterBuilder]
     */
    private function createTester(ObjectProphecy $generateMethod) : array
    {
        $builder = LanguageServerTesterBuilder::createBare()->enableTextDocuments()->enableCommands();
        $builder->addCommand('generate', new GenerateMethodCommand($builder->clientApi(), $builder->workspace(), $generateMethod->reveal(), InMemoryDocumentLocator::fromTextDocuments([TextDocumentBuilder::create('foobar')->uri(self::EXAMPLE_URI)->build()])));
        $tester = $builder->build();
        $tester->textDocument()->open(self::EXAMPLE_URI, self::EXAMPLE_SOURCE);
        return [$tester, $builder];
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\LspCommand\\GenerateMethodCommandTest', 'Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\LspCommand\\GenerateMethodCommandTest', \false);
