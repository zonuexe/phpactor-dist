<?php

namespace Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\WorseReflection\Transformer;

use Generator;
use Phpactor202301\Phpactor\CodeBuilder\Util\TextFormat;
use Phpactor202301\Phpactor\CodeTransform\Adapter\DocblockParser\ParserDocblockUpdater;
use Phpactor202301\Phpactor\CodeTransform\Adapter\WorseReflection\Transformer\UpdateDocblockReturnTransformer;
use Phpactor202301\Phpactor\CodeTransform\Domain\Diagnostic;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\WorseReflection\WorseTestCase;
use Phpactor202301\Phpactor\DocblockParser\DocblockParser;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
class UpdateDocblockReturnTransformerTest extends WorseTestCase
{
    /**
     * @dataProvider provideUpdateReturn
     */
    public function testUpdateReturn(string $example, string $expected) : void
    {
        $source = SourceCode::fromString($example);
        $this->workspace()->put('Example.php', '<?php namespace Namespaced; class NsTest { /** @return Baz[] */public function bazes(): array {}} class Baz{}');
        $reflector = $this->reflectorForWorkspace($example);
        $transformer = $this->createTransformer($reflector);
        $transformed = $transformer->transform($source)->apply($source);
        self::assertEquals($expected, $transformed);
    }
    /**
     * @return Generator<mixed>
     */
    public function provideUpdateReturn() : Generator
    {
        (yield 'add missing docblock' => [<<<'EOT'
<?php

class Foobar {
    public function baz(): array
    {
        return $this->array();
    }

    /** @return array<string,Baz> */
    private function array(): array
    {
        return ['string' => new Baz'];
    }
}
EOT
, <<<'EOT'
<?php

class Foobar {
    /**
     * @return array<string,Baz>
     */
    public function baz(): array
    {
        return $this->array();
    }

    /** @return array<string,Baz> */
    private function array(): array
    {
        return ['string' => new Baz'];
    }
}
EOT
]);
        (yield 'add array literal' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function baz() : array
    {
        return ['foo' => 'bar', 'baz' => 'boo'];
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
     * @return array<string,string>
     */
    public function baz() : array
    {
        return ['foo' => 'bar', 'baz' => 'boo'];
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'add union of array literals' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function baz() : array
    {
        if ($foo) {
            return ['baz' => 'bar'];
        }
        return ['foo' => 'bar', 'baz' => 'boo'];
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
     * @return array<string,string>
     */
    public function baz() : array
    {
        if ($foo) {
            return ['baz' => 'bar'];
        }
        return ['foo' => 'bar', 'baz' => 'boo'];
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'permit wider return types' => [<<<'EOT'
<?php

namespace Phpactor202301;

abstract class Foo
{
}
\class_alias('Phpactor202301\\Foo', 'Foo', \false);
class ConcreteFoo extends Foo
{
}
\class_alias('Phpactor202301\\ConcreteFoo', 'ConcreteFoo', \false);
class Foobar
{
    public function baz() : Foo
    {
        return new ConcreteFoo();
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

abstract class Foo
{
}
\class_alias('Phpactor202301\\Foo', 'Foo', \false);
class ConcreteFoo extends Foo
{
}
\class_alias('Phpactor202301\\ConcreteFoo', 'ConcreteFoo', \false);
class Foobar
{
    public function baz() : Foo
    {
        return new ConcreteFoo();
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'permit wider return types in union' => [<<<'EOT'
<?php

namespace Phpactor202301;

abstract class Foo
{
}
\class_alias('Phpactor202301\\Foo', 'Foo', \false);
class ConcreteFoo extends Foo
{
}
\class_alias('Phpactor202301\\ConcreteFoo', 'ConcreteFoo', \false);
class Baz extends Foo
{
}
\class_alias('Phpactor202301\\Baz', 'Baz', \false);
class Foobar
{
    public function baz() : Foo
    {
        if ($bar) {
            return new Baz();
        }
        return new ConcreteFoo();
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

abstract class Foo
{
}
\class_alias('Phpactor202301\\Foo', 'Foo', \false);
class ConcreteFoo extends Foo
{
}
\class_alias('Phpactor202301\\ConcreteFoo', 'ConcreteFoo', \false);
class Baz extends Foo
{
}
\class_alias('Phpactor202301\\Baz', 'Baz', \false);
class Foobar
{
    public function baz() : Foo
    {
        if ($bar) {
            return new Baz();
        }
        return new ConcreteFoo();
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'but adds generic types' => [<<<'EOT'
<?php

namespace Phpactor202301;

abstract class Foo
{
}
\class_alias('Phpactor202301\\Foo', 'Foo', \false);
class ConcreteFoo extends Foo
{
}
\class_alias('Phpactor202301\\ConcreteFoo', 'ConcreteFoo', \false);
class Foobar
{
    public function baz() : Foo
    {
        /** @var ConcreteFoo<Baz> */
        $foo;
        return $foo;
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

abstract class Foo
{
}
\class_alias('Phpactor202301\\Foo', 'Foo', \false);
class ConcreteFoo extends Foo
{
}
\class_alias('Phpactor202301\\ConcreteFoo', 'ConcreteFoo', \false);
class Foobar
{
    /**
     * @return ConcreteFoo<Baz>
     */
    public function baz() : Foo
    {
        /** @var ConcreteFoo<Baz> */
        $foo;
        return $foo;
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'and interfaces' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface Foo
{
}
\class_alias('Phpactor202301\\Foo', 'Foo', \false);
class ConcreteFoo implements Foo
{
}
\class_alias('Phpactor202301\\ConcreteFoo', 'ConcreteFoo', \false);
class Foobar
{
    public function baz() : Foo
    {
        return new ConcreteFoo();
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

interface Foo
{
}
\class_alias('Phpactor202301\\Foo', 'Foo', \false);
class ConcreteFoo implements Foo
{
}
\class_alias('Phpactor202301\\ConcreteFoo', 'ConcreteFoo', \false);
class Foobar
{
    public function baz() : Foo
    {
        return new ConcreteFoo();
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'add generator' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function baz()
    {
        (yield 'foo');
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
     * @return Generator<string>
     */
    public function baz()
    {
        (yield 'foo');
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'add generator with array value' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function t5()
    {
        (yield 'foo' => ['val', new \stdClass()]);
        (yield 'bar' => ['lav', new \stdClass()]);
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
     * @return Generator<string,array{string,stdClass}>
     */
    public function t5()
    {
        (yield 'foo' => ['val', new \stdClass()]);
        (yield 'bar' => ['lav', new \stdClass()]);
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'adds docblock for array' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function baz() : array
    {
        return \array_map(fn() => null, []);
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
     * @return null[]
     */
    public function baz() : array
    {
        return \array_map(fn() => null, []);
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'does not add non-array return type when array return is given' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function baz() : array
    {
        return $this->foo();
    }
    /**
     * @return mixed
     */
    private function foo()
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
    public function baz() : array
    {
        return $this->foo();
    }
    /**
     * @return mixed
     */
    private function foo()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'adds docblock for closure' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function baz() : \Closure
    {
        return function (string $foo) : int {
        };
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
     * @return Closure(string): int
     */
    public function baz() : \Closure
    {
        return function (string $foo) : int {
        };
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'adds docblock for invoked closure' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function baz()
    {
        return (function (string $foo) : int {
            return 12;
        })();
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
     * @return int
     */
    public function baz()
    {
        return (function (string $foo) : int {
            return 12;
        })();
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'imports classes' => [<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Namespaced\NsTest;
class Foobar
{
    public function baz() : array
    {
        return (new NsTest())->bazes();
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Namespaced\Baz;
use Phpactor202301\Namespaced\NsTest;
class Foobar
{
    /**
     * @return Baz[]
     */
    public function baz() : array
    {
        return (new NsTest())->bazes();
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'inherited type' => [<<<'EOT'
<?php

namespace Phpactor202301;

abstract class Foobag
{
    /**
     * @return Baz[]
     */
    public function baz() : array
    {
        return [];
    }
}
\class_alias('Phpactor202301\\Foobag', 'Foobag', \false);
class Foobar extends Foobag
{
    public function baz() : array
    {
        return [new Baz()];
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

abstract class Foobag
{
    /**
     * @return Baz[]
     */
    public function baz() : array
    {
        return [];
    }
}
\class_alias('Phpactor202301\\Foobag', 'Foobag', \false);
class Foobar extends Foobag
{
    public function baz() : array
    {
        return [new Baz()];
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]);
        (yield 'namespaced array shape' => [<<<'EOT'
<?php

namespace Phpactor202301\Foo;

class Foobar
{
    public function baz() : array
    {
        (yield ['foobar', function (Bar $b) : string {
        }]);
    }
}
EOT
, <<<'EOT'
<?php

namespace Phpactor202301\Foo;

use Generator;
class Foobar
{
    /**
     * @return Generator<array{string,Closure(Bar): string}>
     */
    public function baz() : array
    {
        (yield ['foobar', function (Bar $b) : string {
        }]);
    }
}
EOT
]);
        (yield 'trait' => [<<<'EOT'
<?php

namespace Phpactor202301\Foo;

trait Foobar
{
    public function baz() : array
    {
        (yield ['foobar', function (Bar $b) : string {
        }]);
    }
}
EOT
, <<<'EOT'
<?php

namespace Phpactor202301\Foo;

use Generator;
trait Foobar
{
    /**
     * @return Generator<array{string,Closure(Bar): string}>
     */
    public function baz() : array
    {
        (yield ['foobar', function (Bar $b) : string {
        }]);
    }
}
EOT
]);
        (yield 'updates existing docblock' => [<<<'EOT'
<?php

namespace Phpactor202301\Foo;

trait Foobar
{
    /**
     *
     */
    public function baz() : array
    {
        (yield ['foobar', function (Bar $b) : string {
        }]);
    }
}
EOT
, <<<'EOT'
<?php

namespace Phpactor202301\Foo;

use Generator;
trait Foobar
{
    /**
     *
     * @return Generator<array{string,Closure(Bar): string}>
     */
    public function baz() : array
    {
        (yield ['foobar', function (Bar $b) : string {
        }]);
    }
}
EOT
]);
        (yield 'updates existing docblock with other tags' => [<<<'EOT'
<?php

namespace Phpactor202301\Foo;

trait Foobar
{
    /**
     * @author Daniel Leech
     */
    public function baz() : array
    {
        (yield ['foobar', function (Bar $b) : string {
        }]);
    }
}
EOT
, <<<'EOT'
<?php

namespace Phpactor202301\Foo;

use Generator;
trait Foobar
{
    /**
     * @author Daniel Leech
     * @return Generator<array{string,Closure(Bar): string}>
     */
    public function baz() : array
    {
        (yield ['foobar', function (Bar $b) : string {
        }]);
    }
}
EOT
]);
    }
    /**
     * @dataProvider provideDiagnostics
     * @param string[] $expected
     */
    public function testDiagnostics(string $example, array $expected) : void
    {
        $source = SourceCode::fromString($example);
        $reflector = $this->reflectorForWorkspace($example);
        $transformer = $this->createTransformer($reflector);
        $diagnostics = \array_map(fn(Diagnostic $d) => $d->message(), \iterator_to_array($transformer->diagnostics($source)));
        self::assertEquals($expected, $diagnostics);
    }
    /**
     * @return Generator<mixed>
     */
    public function provideDiagnostics() : Generator
    {
        (yield 'no methods' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, []]);
        (yield 'ignore constructor' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function __construct()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, []]);
        (yield 'missing return type corresponds to method return type' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function baz() : string
    {
        return 'string';
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, []]);
        (yield 'diagnostics for missing docblock' => [<<<'EOT'
<?php

class Foobar {
    public function baz(): array
    {
        return $this->array();
    }

    /** @return array<string,Baz> */
    private function array(): array
    {
        return ['string' => new Baz'];
    }
}
EOT
, ['Missing @return array<string,Baz>']]);
    }
    private function createTransformer(Reflector $reflector) : UpdateDocblockReturnTransformer
    {
        return new UpdateDocblockReturnTransformer($reflector, $this->updater(), $this->builderFactory($reflector), new ParserDocblockUpdater(DocblockParser::create(), new TextFormat()));
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Tests\\Adapter\\WorseReflection\\Transformer\\UpdateDocblockReturnTransformerTest', 'Phpactor\\CodeTransform\\Tests\\Adapter\\WorseReflection\\Transformer\\UpdateDocblockReturnTransformerTest', \false);
