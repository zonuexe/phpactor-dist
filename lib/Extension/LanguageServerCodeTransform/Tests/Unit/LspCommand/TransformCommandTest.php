<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Tests\Unit\LspCommand;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeTransform\Domain\Diagnostics;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\CodeTransform\Domain\Transformer;
use Phpactor202301\Phpactor\CodeTransform\Domain\Transformers;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LspCommand\TransformCommand;
use Phpactor202301\Phpactor\LanguageServerProtocol\ApplyWorkspaceEditResponse;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\ResponseMessage;
use Phpactor202301\Phpactor\LanguageServer\LanguageServerTesterBuilder;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
use function Phpactor202301\Amp\Promise\wait;
class TransformCommandTest extends TestCase
{
    const EXAMPLE_TRANSFORM_NAME = 'test_transform';
    public function testAppliesTransform() : void
    {
        $testTransformer = new TestTransformer();
        $transformers = new Transformers([self::EXAMPLE_TRANSFORM_NAME => $testTransformer]);
        $tester = LanguageServerTesterBuilder::create();
        $tester->addCommand('transform', new TransformCommand($tester->clientApi(), $tester->workspace(), $transformers));
        $watcher = $tester->responseWatcher();
        $tester = $tester->build();
        $tester->textDocument()->open('file:///foobar', 'foobar');
        $promise = $tester->workspace()->executeCommand('transform', ['file:///foobar', self::EXAMPLE_TRANSFORM_NAME]);
        $watcher->resolveLastResponse(new ApplyWorkspaceEditResponse(\true));
        $response = wait($promise);
        self::assertInstanceOf(ResponseMessage::class, $response);
        self::assertInstanceOf(ApplyWorkspaceEditResponse::class, $response->result);
        self::assertNotNull($testTransformer->code);
        self::assertEquals('/foobar', $testTransformer->code->path());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\LspCommand\\TransformCommandTest', 'Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\LspCommand\\TransformCommandTest', \false);
class TestTransformer implements Transformer
{
    public SourceCode $code;
    public function transform(SourceCode $code) : TextEdits
    {
        $this->code = $code;
        return TextEdits::none();
    }
    public function diagnostics(SourceCode $code) : Diagnostics
    {
        return Diagnostics::none();
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\LspCommand\\TestTransformer', 'Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\Unit\\LspCommand\\TestTransformer', \false);
