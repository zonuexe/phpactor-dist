<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Tests\Unit\LspCommand;

use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\PropertyAccessGenerator;
use Phpactor202301\Phpactor\LanguageServerProtocol\ApplyWorkspaceEditResponse;
use Phpactor202301\Phpactor\LanguageServer\LanguageServerTesterBuilder;
use Phpactor202301\Phpactor\LanguageServer\Test\LanguageServerTester;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\TextEditConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand\PropertyAccessGeneratorCommand;
use Phpactor202301\Phpactor\LanguageServerProtocol\WorkspaceEdit;
use Phpactor202301\Phpactor\TextDocument\TextEdit;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Prophecy\Argument;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
class PropertyAccessGeneratorCommandTest extends TestCase
{
    use ProphecyTrait;
    const EXAMPLE_SOURCE = '<?php ';
    const EXAMPLE_URI = 'file:///file.php';
    const EXAMPLE_OFFSET = 5;
    public function testSuccessfulCall() : void
    {
        $textEdits = new TextEdits(TextEdit::create(self::EXAMPLE_OFFSET, 1, 'test'));
        $generateAccessors = $this->prophesize(PropertyAccessGenerator::class);
        $generateAccessors->generate(Argument::type(SourceCode::class), ['foo'], self::EXAMPLE_OFFSET)->shouldBeCalled()->willReturn($textEdits);
        [$tester, $builder] = $this->createTester($generateAccessors);
        $tester->workspace()->executeCommand('generate', [self::EXAMPLE_URI, self::EXAMPLE_OFFSET, ['foo']]);
        $builder->responseWatcher()->resolveLastResponse(new ApplyWorkspaceEditResponse(\true));
        $applyEdit = $builder->transmitter()->filterByMethod('workspace/applyEdit')->shiftRequest();
        self::assertNotNull($applyEdit);
        self::assertEquals(['edit' => new WorkspaceEdit([self::EXAMPLE_URI => TextEditConverter::toLspTextEdits($textEdits, self::EXAMPLE_SOURCE)]), 'label' => 'Generate accessors'], $applyEdit->params);
    }
    /**
     * @return {LanguageServerTester,LanguageServerTesterBuilder]
     */
    private function createTester(ObjectProphecy $generateAccessors) : array
    {
        $builder = LanguageServerTesterBuilder::createBare()->enableTextDocuments()->enableCommands();
        $builder->addCommand('generate', new PropertyAccessGeneratorCommand('generate_accessors', $builder->clientApi(), $builder->workspace(), $generateAccessors->reveal(), 'Generate accessors'));
        $tester = $builder->build();
        $tester->textDocument()->open(self::EXAMPLE_URI, self::EXAMPLE_SOURCE);
        return [$tester, $builder];
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\LspCommand\\PropertyAccessGeneratorCommandTest', 'Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\LspCommand\\PropertyAccessGeneratorCommandTest', \false);
