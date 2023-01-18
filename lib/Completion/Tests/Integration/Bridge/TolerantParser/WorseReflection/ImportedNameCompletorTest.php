<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Integration\Bridge\TolerantParser\WorseReflection;

use Generator;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\Qualifier\ClassQualifier;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantCompletor;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\WorseReflection\ImportedNameCompletor;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\Completion\Tests\Integration\Bridge\TolerantParser\TolerantCompletorTestCase;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
class ImportedNameCompletorTest extends TolerantCompletorTestCase
{
    /**
     * @dataProvider provideComplete
     * @param array<string,mixed> $expected
     */
    public function testComplete(string $source, array $expected) : void
    {
        $this->assertComplete($source, $expected);
    }
    public function provideComplete() : Generator
    {
        (yield 'no imports' => [<<<'EOT'
<?php

$class = new B<>
EOT
, []]);
        (yield 'import local' => [<<<'EOT'
<?php

use Barfoo;

$class = new B<>
EOT
, [['type' => Suggestion::TYPE_CLASS, 'name' => 'Barfoo', 'short_description' => 'Barfoo']]]);
        (yield 'import with aliased class' => [<<<'EOT'
<?php namespace {
    use Barfoo as BarfooThis;

    $class = new B<>
}
EOT
, [['type' => Suggestion::TYPE_CLASS, 'name' => 'BarfooThis', 'short_description' => 'Barfoo']]]);
        (yield 'import with aliased class and concrete class' => [<<<'EOT'
<?php namespace {
    use Barfoo as BarfooThis;
    use Barbar;

    $class = new B<>
}
EOT
, [['type' => Suggestion::TYPE_CLASS, 'name' => 'Barbar', 'short_description' => 'Barbar'], ['type' => Suggestion::TYPE_CLASS, 'name' => 'BarfooThis', 'short_description' => 'Barfoo']]]);
        (yield 'import multi-part non-aliased class' => [<<<'EOT'
<?php

    use Foo\Bar\Barfoo;
    use Foo\Bar\Barbar;

    $class = new B<>
}
EOT
, [['type' => Suggestion::TYPE_CLASS, 'name' => 'Barbar', 'short_description' => 'Phpactor202301\\Foo\\Bar\\Barbar'], ['type' => Suggestion::TYPE_CLASS, 'name' => 'Barfoo', 'short_description' => 'Phpactor202301\\Foo\\Bar\\Barfoo']]]);
    }
    protected function createTolerantCompletor(TextDocument $source) : TolerantCompletor
    {
        $reflector = ReflectorBuilder::create()->addSource($source)->build();
        return new ImportedNameCompletor(new ClassQualifier(0));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Integration\\Bridge\\TolerantParser\\WorseReflection\\ImportedNameCompletorTest', 'Phpactor\\Completion\\Tests\\Integration\\Bridge\\TolerantParser\\WorseReflection\\ImportedNameCompletorTest', \false);
