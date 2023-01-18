<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Tests\Unit\Domain\Builder;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Builder\Exception\InvalidBuilderException;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Builder\NamedBuilder;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Builder\SourceCodeBuilder;
class MethodBuilderTest extends TestCase
{
    use \Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
    public function testExceptionOnAddNonParameterBuilder() : void
    {
        $this->expectException(InvalidBuilderException::class);
        $builder = $this->prophesize(NamedBuilder::class);
        SourceCodeBuilder::create()->class('One')->method('two')->add($builder->reveal());
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Tests\\Unit\\Domain\\Builder\\MethodBuilderTest', 'Phpactor\\CodeBuilder\\Tests\\Unit\\Domain\\Builder\\MethodBuilderTest', \false);
