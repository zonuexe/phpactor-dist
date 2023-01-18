<?php

namespace Phpactor202301\Phpactor\Extension\CodeTransform\Tests\Unit\Rpc;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeTransform\CodeTransform;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\CodeTransform\Domain\Transformer;
use Phpactor202301\Phpactor\CodeTransform\Domain\Transformers;
use Phpactor202301\Phpactor\Extension\CodeTransform\Rpc\TransformHandler;
use Phpactor202301\Phpactor\Extension\Rpc\Response\InputCallbackResponse;
use Phpactor202301\Phpactor\Extension\Rpc\Response\Input\ChoiceInput;
use Phpactor202301\Phpactor\Extension\Rpc\Response\UpdateFileSourceResponse;
use Phpactor202301\Phpactor\Extension\Rpc\Test\HandlerTester;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
class TransformHandlerTest extends TestCase
{
    use ProphecyTrait;
    const EXAMPLE_NEW_PATH = '/path/to/new.php';
    const EXAMPLE_SOURCE_CODE = '<?php';
    private ObjectProphecy $codeTransform;
    private HandlerTester $tester;
    private ObjectProphecy $transformer;
    public function setUp() : void
    {
        $this->codeTransform = $this->prophesize(CodeTransform::class);
        $this->tester = new HandlerTester(new TransformHandler($this->codeTransform->reveal()));
        $this->transformer = $this->prophesize(Transformer::class);
    }
    public function testPresentsTransformerChoice() : void
    {
        $this->codeTransform->transformers()->willReturn(new Transformers(['trans' => $this->transformer->reveal()]));
        $response = $this->tester->handle('transform', ['path' => self::EXAMPLE_NEW_PATH, 'source' => self::EXAMPLE_SOURCE_CODE]);
        $this->assertInstanceOf(InputCallbackResponse::class, $response);
        $this->assertCount(1, $response->inputs());
        $choiceInput = $response->inputs()[0];
        $this->assertInstanceOf(ChoiceInput::class, $choiceInput);
        $this->assertCount(1, $choiceInput->choices());
        $this->assertEquals(['trans' => 'trans'], $choiceInput->choices());
    }
    public function testTransformsCode() : void
    {
        $expectedTransformed = SourceCode::fromStringAndPath('HALLO', '/GOODBYE');
        $this->codeTransform->transformers()->willReturn(new Transformers(['trans' => $this->transformer->reveal()]));
        $this->codeTransform->transform(SourceCode::fromStringAndPath(self::EXAMPLE_SOURCE_CODE, self::EXAMPLE_NEW_PATH), ['trans'])->willReturn($expectedTransformed);
        $response = $this->tester->handle('transform', [TransformHandler::PARAM_PATH => self::EXAMPLE_NEW_PATH, TransformHandler::PARAM_SOURCE => self::EXAMPLE_SOURCE_CODE, TransformHandler::PARAM_NAME => 'trans']);
        $this->assertInstanceOf(UpdateFileSourceResponse::class, $response);
        $this->assertEquals(self::EXAMPLE_NEW_PATH, $response->path());
        $this->assertEquals('HALLO', $response->newSource());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\CodeTransform\\Tests\\Unit\\Rpc\\TransformHandlerTest', 'Phpactor\\Extension\\CodeTransform\\Tests\\Unit\\Rpc\\TransformHandlerTest', \false);
