<?php

namespace Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\WorseReflection\Transformer;

use Generator;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\CodeTransform\Adapter\WorseReflection\Transformer\AddMissingProperties;
use Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\WorseReflection\WorseTestCase;
class AddMissingPropertiesTest extends WorseTestCase
{
    /**
     * @dataProvider provideCompleteConstructor
     */
    public function testAddMissingProperties(string $example, string $expected) : void
    {
        $this->workspace()->put('Bag.php', '<?php namespace Test; class Bag { public function bar(): Boo {} }');
        $this->workspace()->put('Boo.php', '<?php namespace Test; class Boo{}');
        $source = SourceCode::fromString($example);
        $transformer = new AddMissingProperties($this->reflectorForWorkspace($example), $this->updater());
        $transformed = $transformer->transform(SourceCode::fromString($source));
        $this->assertEquals((string) $expected, (string) $transformed->apply($source));
    }
    /**
     * @return Generator<string,array{string,string}>
     */
    public function provideCompleteConstructor() : Generator
    {
        (yield 'It does nothing on source with no classes' => [<<<'EOT'
<?php


EOT
, <<<'EOT'
<?php


EOT
]);
        (yield 'It adds missing properties' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function hello()
    {
        $this->hello = 'Hello';
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @var string
     */
    private $hello;
    public function hello()
    {
        $this->hello = 'Hello';
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'It adds missing properties with documented type' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @param array<string,mixed> $bar
     */
    public function hello(array $bar)
    {
        $this->hello = $bar;
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @var array<string,mixed>
     */
    private $hello;
    /**
     * @param array<string,mixed> $bar
     */
    public function hello(array $bar)
    {
        $this->hello = $bar;
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'It ignores existing properties' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @var string
     */
    private $hello;
    public function hello()
    {
        $this->hello = 'Hello';
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @var string
     */
    private $hello;
    public function hello()
    {
        $this->hello = 'Hello';
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'It ignores existing properties of a different visibility' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @var string
     */
    public $hello;
    public function hello()
    {
        $this->hello = 'Hello';
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @var string
     */
    public $hello;
    public function hello()
    {
        $this->hello = 'Hello';
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'It appends new properties' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @var string
     */
    public $hello;
    public function hello()
    {
        $this->foobar = 1234;
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @var string
     */
    public $hello;
    /**
     * @var int
     */
    private $foobar;
    public function hello()
    {
        $this->foobar = 1234;
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'It appends new properties in a namespaced class' => [<<<'EOT'
<?php

namespace Phpactor202301\Hello;

class Foobar
{
    /**
     * @var string
     */
    public $hello;
    public function hello()
    {
        $this->foobar = 1234;
    }
}
EOT
, <<<'EOT'
<?php

namespace Phpactor202301\Hello;

class Foobar
{
    /**
     * @var string
     */
    public $hello;
    /**
     * @var int
     */
    private $foobar;
    public function hello()
    {
        $this->foobar = 1234;
    }
}
EOT
]);
        (yield 'Properties should only be taken from current class' => [<<<'EOT'
<?php

namespace Phpactor202301\Hello;

class Dodo
{
    public function goodbye()
    {
        $this->dodo = 'string';
    }
}
class Foobar extends Dodo
{
    public function hello()
    {
        $this->foobar = 1234;
    }
}
EOT
, <<<'EOT'
<?php

namespace Phpactor202301\Hello;

class Dodo
{
    /**
     * @var string
     */
    private $dodo;
    public function goodbye()
    {
        $this->dodo = 'string';
    }
}
class Foobar extends Dodo
{
    /**
     * @var int
     */
    private $foobar;
    public function hello()
    {
        $this->foobar = 1234;
    }
}
EOT
]);
        (yield 'It adds missing properties using the imported type' => [<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\MyLibrary\Hello;
class Foobar
{
    public function hello()
    {
        $this->hello = new Hello();
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\MyLibrary\Hello;
class Foobar
{
    /**
     * @var Hello
     */
    private $hello;
    public function hello()
    {
        $this->hello = new Hello();
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'It missing properties with an untyped parameter' => [<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\MyLibrary\Hello;
class Foobar
{
    public function hello($string)
    {
        $this->hello = $string;
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\MyLibrary\Hello;
class Foobar
{
    private $hello;
    public function hello($string)
    {
        $this->hello = $string;
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'It adds missing trait properties within the Trait' => [<<<'EOT'
<?php

namespace Phpactor202301;

trait Foobar
{
    public function hello()
    {
        $this->hello = 'goodbye';
    }
}
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

trait Foobar
{
    /**
     * @var string
     */
    private $hello;
    public function hello()
    {
        $this->hello = 'goodbye';
    }
}
EOT
]);
        (yield 'It adds missing property from call expression' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function hello()
    {
        $this->bar = $this->bar();
    }
    public function bar() : string
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @var string
     */
    private $bar;
    public function hello()
    {
        $this->bar = $this->bar();
    }
    public function bar() : string
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'It adds missing property from array assignment' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function hello()
    {
        $this->bar['foo'] = $this->bar();
    }
    public function bar() : string
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @var array<string,string>
     */
    private $bar = [];
    public function hello()
    {
        $this->bar['foo'] = $this->bar();
    }
    public function bar() : string
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'It adds missing property from array add' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function hello()
    {
        $this->bar[] = $this->bar();
    }
    public function bar() : string
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @var string[]
     */
    private $bar = [];
    public function hello()
    {
        $this->bar[] = $this->bar();
    }
    public function bar() : string
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'It imports classes' => [<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Test\Bag;
class Foobar
{
    public function hello()
    {
        $foo = new Bag();
        $this->foo = $foo->bar();
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Test\Bag;
use Phpactor202301\Test\Boo;
class Foobar
{
    /**
     * @var Boo
     */
    private $foo;
    public function hello()
    {
        $foo = new Bag();
        $this->foo = $foo->bar();
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
    }
    /**
     * @dataProvider provideDiagnostics
     */
    public function testDiagnostics(string $example, int $diagnosticsCount) : void
    {
        $source = SourceCode::fromString($example);
        $transformer = new AddMissingProperties($this->reflectorForWorkspace($example), $this->updater());
        $diagnostics = $transformer->diagnostics($source);
        $this->assertCount($diagnosticsCount, $diagnostics);
    }
    /**
     * @return Generator<mixed>
     */
    public function provideDiagnostics() : Generator
    {
        (yield 'empty' => ['<?php', 0]);
        (yield 'missing properties' => ['<?php class A { public function bar() { $this->bar = "foo"; } }', 1]);
        (yield 'not missing properties' => ['<?php class A { private $bar; public function bar() { $this->bar = "foo"; } }', 0]);
        (yield 'ignores property from another class' => [<<<'EOT'
<?php

namespace Phpactor202301\Test;

use Phpactor202301\Test\Yet\AnotherClass;
class Foo
{
    public function test(AnotherClass $anotherClass) : void
    {
        \assert($anotherClass->doesNotMatter instanceof SecretImplementation);
        $anotherClass->doesNotMatter = 'test';
    }
}
EOT
, 0]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Tests\\Adapter\\WorseReflection\\Transformer\\AddMissingPropertiesTest', 'Phpactor\\CodeTransform\\Tests\\Adapter\\WorseReflection\\Transformer\\AddMissingPropertiesTest', \false);
