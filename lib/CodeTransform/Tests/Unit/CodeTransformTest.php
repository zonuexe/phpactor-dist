<?php

namespace Phpactor202301\Phpactor\CodeTransform\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeTransform\CodeTransform;
use Phpactor202301\Phpactor\CodeTransform\Domain\Transformer;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextEdit;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
use Phpactor202301\Prophecy\Argument;
use Phpactor202301\Phpactor\CodeTransform\Domain\Transformers;
class CodeTransformTest extends TestCase
{
    use \Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
    /**
     * @testdox It should apply the given transformers to source code.
     */
    public function testApplyTransformers() : void
    {
        $expectedCode = SourceCode::fromString('hello goodbye');
        $trans1 = $this->prophesize(Transformer::class);
        $trans1->transform(Argument::type(SourceCode::class))->willReturn(TextEdits::one(TextEdit::create(ByteOffset::fromInt(5), 0, ' goodbye')));
        $code = $this->create(['one' => $trans1->reveal()])->transform('hello', ['one']);
        $this->assertEquals($expectedCode, $code);
    }
    public function testAcceptsSourceCodeAsParameter() : void
    {
        $expectedCode = SourceCode::fromStringAndPath('hello goodbye', '/path/to');
        $trans1 = $this->prophesize(Transformer::class);
        $trans1->transform($expectedCode)->willReturn(TextEdits::none());
        $code = $this->create(['one' => $trans1->reveal()])->transform($expectedCode, ['one']);
        $this->assertEquals($expectedCode, $code);
    }
    public function create(array $transformers) : CodeTransform
    {
        /** @phpstan-ignore-next-line */
        return CodeTransform::fromTransformers(Transformers::fromArray($transformers));
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Tests\\Unit\\CodeTransformTest', 'Phpactor\\CodeTransform\\Tests\\Unit\\CodeTransformTest', \false);
