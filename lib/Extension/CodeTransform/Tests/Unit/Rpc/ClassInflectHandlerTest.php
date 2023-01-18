<?php

namespace Phpactor202301\Phpactor\Extension\CodeTransform\Tests\Unit\Rpc;

use Phpactor202301\Phpactor\ClassFileConverter\Domain\ClassName as ConvertedClassName;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\ClassNameCandidates;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\FilePath;
use Phpactor202301\Phpactor\CodeTransform\Domain\ClassName;
use Phpactor202301\Phpactor\CodeTransform\Domain\GenerateFromExisting;
use Phpactor202301\Phpactor\CodeTransform\Domain\Generators;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\Extension\CodeTransform\Rpc\ClassInflectHandler;
use Phpactor202301\Phpactor\Extension\Rpc\Handler;
use Phpactor202301\Phpactor\Extension\Rpc\Response\ReplaceFileSourceResponse;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
class ClassInflectHandlerTest extends AbstractClassGenerateHandlerTest
{
    use ProphecyTrait;
    private ObjectProphecy $generator;
    public function setUp() : void
    {
        parent::setUp();
        $this->generator = $this->prophesize(GenerateFromExisting::class);
    }
    public function createHandler() : Handler
    {
        return new ClassInflectHandler(new Generators([self::EXAMPLE_VARIANT => $this->generator->reveal()]), $this->fileToClass->reveal());
    }
    public function testInflectsClass() : void
    {
        $this->fileToClass->fileToClassCandidates(FilePath::fromString(self::EXAMPLE_PATH))->willReturn(ClassNameCandidates::fromClassNames([$class1 = ConvertedClassName::fromString(self::EXAMPLE_CLASS_1)]));
        $this->fileToClass->fileToClassCandidates(FilePath::fromString($this->exampleNewPath()))->willReturn(ClassNameCandidates::fromClassNames([$class2 = ConvertedClassName::fromString(self::EXAMPLE_CLASS_2)]));
        $this->generator->generateFromExisting(ClassName::fromString(self::EXAMPLE_CLASS_1), ClassName::fromString(self::EXAMPLE_CLASS_2))->willReturn(SourceCode::fromStringAndPath('<?php', $this->exampleNewPath()));
        $response = $this->createTester()->handle(ClassInflectHandler::NAME, [ClassInflectHandler::PARAM_CURRENT_PATH => self::EXAMPLE_PATH, ClassInflectHandler::PARAM_NEW_PATH => $this->exampleNewPath(), ClassInflectHandler::PARAM_VARIANT => self::EXAMPLE_VARIANT]);
        $this->assertInstanceOf(ReplaceFileSourceResponse::class, $response);
        $this->assertEquals($this->exampleNewPath(), $response->path());
        $this->assertFileExists($this->exampleNewPath());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\CodeTransform\\Tests\\Unit\\Rpc\\ClassInflectHandlerTest', 'Phpactor\\Extension\\CodeTransform\\Tests\\Unit\\Rpc\\ClassInflectHandlerTest', \false);
