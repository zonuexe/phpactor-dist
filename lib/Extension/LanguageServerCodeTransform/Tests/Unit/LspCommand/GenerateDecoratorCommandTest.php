<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Tests\Unit\LspCommand;

use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\GenerateDecorator;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand\GenerateDecoratorCommand;
use Phpactor202301\Phpactor\LanguageServerProtocol\ApplyWorkspaceEditResponse;
use Phpactor202301\Phpactor\LanguageServer\LanguageServerTesterBuilder;
use Phpactor202301\Phpactor\LanguageServer\Test\LanguageServerTester;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\TextEditConverter;
use Phpactor202301\Phpactor\LanguageServerProtocol\WorkspaceEdit;
use Phpactor202301\Phpactor\TextDocument\TextEdit;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Prophecy\Argument;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
class GenerateDecoratorCommandTest extends TestCase
{
    use ProphecyTrait;
    const EXAMPLE_SOURCE = '<?php interface SomeInterface{} class ClassesAreCool implements SomeInterface {}';
    const EXAMPLE_URI = 'file:///file.php';
    const EXAMPLE_OFFSET = 48;
    public function testSuccessfulCall() : void
    {
        $textEdits = new TextEdits(TextEdit::create(self::EXAMPLE_OFFSET, 1, 'test'));
        $generateAccessors = $this->prophesize(GenerateDecorator::class);
        $generateAccessors->getTextEdits(Argument::type(SourceCode::class), 'SomeInterface')->shouldBeCalled()->willReturn($textEdits);
        [$tester, $builder] = $this->createTester($generateAccessors);
        $tester->workspace()->executeCommand('generate_decorator', [self::EXAMPLE_URI, 'SomeInterface']);
        $builder->responseWatcher()->resolveLastResponse(new ApplyWorkspaceEditResponse(\true));
        $applyEdit = $builder->transmitter()->filterByMethod('workspace/applyEdit')->shiftRequest();
        self::assertNotNull($applyEdit);
        self::assertEquals(['edit' => new WorkspaceEdit([self::EXAMPLE_URI => TextEditConverter::toLspTextEdits($textEdits, self::EXAMPLE_SOURCE)]), 'label' => 'Generate decoration'], $applyEdit->params);
    }
    /**
     * @return {LanguageServerTester,LanguageServerTesterBuilder]
     */
    private function createTester(ObjectProphecy $generateAccessors) : array
    {
        $builder = LanguageServerTesterBuilder::createBare()->enableTextDocuments()->enableCommands();
        $builder->addCommand('generate_decorator', new GenerateDecoratorCommand($builder->clientApi(), $builder->workspace(), $generateAccessors->reveal()));
        $tester = $builder->build();
        $tester->textDocument()->open(self::EXAMPLE_URI, self::EXAMPLE_SOURCE);
        return [$tester, $builder];
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\LspCommand\\GenerateDecoratorCommandTest', 'Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\LspCommand\\GenerateDecoratorCommandTest', \false);
