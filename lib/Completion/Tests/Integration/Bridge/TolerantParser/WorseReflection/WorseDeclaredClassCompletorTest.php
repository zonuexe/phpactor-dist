<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Integration\Bridge\TolerantParser\WorseReflection;

use Generator;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantCompletor;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\WorseReflection\WorseDeclaredClassCompletor;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\Completion\Tests\Integration\Bridge\TolerantParser\TolerantCompletorTestCase;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator\StubSourceLocator;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
class WorseDeclaredClassCompletorTest extends TolerantCompletorTestCase
{
    /**
     * @dataProvider provideComplete
     */
    public function testComplete(string $source, array $expected) : void
    {
        $this->assertComplete($source, $expected);
    }
    public function provideComplete() : Generator
    {
        (yield 'array object' => [<<<'EOT'
<?php

$class = new RangeException<>
EOT
, [['type' => Suggestion::TYPE_CLASS, 'name' => 'RangeException']]]);
    }
    protected function createTolerantCompletor(TextDocument $source) : TolerantCompletor
    {
        $reflector = ReflectorBuilder::create()->addLocator(new StubSourceLocator(ReflectorBuilder::create()->build(), __DIR__ . '/../../../../../../../vendor/jetbrains/phpstorm-stubs', __DIR__ . '/../../../../../cache'))->addSource($source)->build();
        return new WorseDeclaredClassCompletor($reflector, $this->formatter());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Integration\\Bridge\\TolerantParser\\WorseReflection\\WorseDeclaredClassCompletorTest', 'Phpactor\\Completion\\Tests\\Integration\\Bridge\\TolerantParser\\WorseReflection\\WorseDeclaredClassCompletorTest', \false);
