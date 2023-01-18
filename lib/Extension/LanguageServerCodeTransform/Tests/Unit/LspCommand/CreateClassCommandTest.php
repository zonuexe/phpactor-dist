<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Tests\Unit\LspCommand;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\ClassName as PhpactorClassName;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\ClassNameCandidates;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\FilePath;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\FileToClass;
use Phpactor202301\Phpactor\CodeTransform\Domain\ClassName;
use Phpactor202301\Phpactor\CodeTransform\Domain\GenerateNew;
use Phpactor202301\Phpactor\CodeTransform\Domain\Generators;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand\CreateClassCommand;
use Phpactor202301\Phpactor\LanguageServerProtocol\ApplyWorkspaceEditResponse;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\ResponseMessage;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ResponseWatcher\TestResponseWatcher;
use Phpactor202301\Phpactor\LanguageServer\LanguageServerTesterBuilder;
use Phpactor202301\Phpactor\LanguageServer\Test\LanguageServerTester;
use function Phpactor202301\Amp\Promise\wait;
class CreateClassCommandTest extends TestCase
{
    const EXAMPLE_VARIANT = 'test_transform';
    public function testAppliesTransform() : void
    {
        [$tester, $watcher] = $this->createTester();
        $tester->textDocument()->open('file:///foobar', 'foobar');
        $promise = $tester->workspace()->executeCommand('create_class', ['file:///foobar', self::EXAMPLE_VARIANT]);
        $watcher->resolveLastResponse(new ApplyWorkspaceEditResponse(\true));
        $response = wait($promise);
        self::assertInstanceOf(ResponseMessage::class, $response);
        self::assertInstanceOf(ApplyWorkspaceEditResponse::class, $response->result);
    }
    public function testAppliesTransformForNonExistingClass() : void
    {
        [$tester, $watcher] = $this->createTester();
        $promise = $tester->workspace()->executeCommand('create_class', ['file:///foobar', self::EXAMPLE_VARIANT]);
        $watcher->resolveLastResponse(new ApplyWorkspaceEditResponse(\true));
        $response = wait($promise);
        self::assertInstanceOf(ResponseMessage::class, $response);
        self::assertInstanceOf(ApplyWorkspaceEditResponse::class, $response->result);
    }
    /**
     * @return array{LanguageServerTester,TestResponseWatcher}
     */
    private function createTester() : array
    {
        $generator = new TestGenerator();
        $generators = new Generators([self::EXAMPLE_VARIANT => $generator]);
        $fileToClass = new TestFileToClass();
        $tester = LanguageServerTesterBuilder::create();
        $tester->addCommand('create_class', new CreateClassCommand($tester->clientApi(), $tester->workspace(), $generators, $fileToClass));
        $watcher = $tester->responseWatcher();
        $tester = $tester->build();
        return [$tester, $watcher];
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\LspCommand\\CreateClassCommandTest', 'Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\LspCommand\\CreateClassCommandTest', \false);
class TestGenerator implements GenerateNew
{
    public const EXAMPLE_TEXT = 'hello';
    public const EXAMPLE_PATH = '/path';
    public function generateNew(ClassName $targetName) : SourceCode
    {
        return SourceCode::fromStringAndPath(self::EXAMPLE_TEXT, self::EXAMPLE_PATH);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\LspCommand\\TestGenerator', 'Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\LspCommand\\TestGenerator', \false);
class TestFileToClass implements FileToClass
{
    public const TEST_CLASS_NAME = 'Foobar';
    public function fileToClassCandidates(FilePath $filePath) : ClassNameCandidates
    {
        return ClassNameCandidates::fromClassNames([PhpactorClassName::fromString(self::TEST_CLASS_NAME)]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\LspCommand\\TestFileToClass', 'Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\LspCommand\\TestFileToClass', \false);
