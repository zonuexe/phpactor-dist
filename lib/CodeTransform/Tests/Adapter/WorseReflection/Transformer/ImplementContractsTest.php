<?php

namespace Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\WorseReflection\Transformer;

use Generator;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\CodeTransform\Adapter\WorseReflection\Transformer\ImplementContracts;
use Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\WorseReflection\WorseTestCase;
class ImplementContractsTest extends WorseTestCase
{
    /**
     * @dataProvider provideCompleteConstructor
     */
    public function testImplementContracts(string $example, string $expected) : void
    {
        $source = SourceCode::fromString($example);
        $reflector = $this->reflectorForWorkspace($example);
        $transformer = new ImplementContracts($reflector, $this->updater(), $this->builderFactory($reflector));
        $transformed = $transformer->transform($source);
        $this->assertEquals((string) $expected, (string) $transformed->apply($source));
    }
    /**
     * @return array<string,array<int,string>>
     */
    public function provideCompleteConstructor() : array
    {
        return ['It does nothing on source with no classes' => [<<<'EOT'
<?php


EOT
, <<<'EOT'
<?php


EOT
], 'It does nothing on class with no interfaces or parent classes' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
], 'It implements an interface' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface Rabbit
{
    public function dig(int $depth = 5);
}
\class_alias('Phpactor202301\\Rabbit', 'Rabbit', \false);
class Foobar implements Rabbit
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

interface Rabbit
{
    public function dig(int $depth = 5);
}
\class_alias('Phpactor202301\\Rabbit', 'Rabbit', \false);
class Foobar implements Rabbit
{
    public function dig(int $depth = 5)
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
], 'It implements a static methods' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface Rabbit
{
    public static function dig(int $depth = 5) : Dirt;
}
\class_alias('Phpactor202301\\Rabbit', 'Rabbit', \false);
class Foobar implements Rabbit
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

interface Rabbit
{
    public static function dig(int $depth = 5) : Dirt;
}
\class_alias('Phpactor202301\\Rabbit', 'Rabbit', \false);
class Foobar implements Rabbit
{
    public static function dig(int $depth = 5) : Dirt
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
], 'It implements multiple interfaces' => [<<<'EOT'
<?php

interface Dog
{
    public function bark(int $volume = 11): Sound
}

interface Rabbit
{
    public function dig(int $depth = 5): Dirt
}

class Foobar implements Rabbit, Dog
{
}
EOT
, <<<'EOT'
<?php

interface Dog
{
    public function bark(int $volume = 11): Sound
}

interface Rabbit
{
    public function dig(int $depth = 5): Dirt
}

class Foobar implements Rabbit, Dog
{
    public function dig(int $depth = 5): Dirt
    {
    }

    public function bark(int $volume = 11): Sound
    {
    }
}
EOT
], 'It does adds inherit docblocks' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface Bird
{
    /**
     * Emit chirping sound.
     */
    public function chirp();
}
\class_alias('Phpactor202301\\Bird', 'Bird', \false);
class Foobar implements Bird
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

interface Bird
{
    /**
     * Emit chirping sound.
     */
    public function chirp();
}
\class_alias('Phpactor202301\\Bird', 'Bird', \false);
class Foobar implements Bird
{
    public function chirp()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
], 'It is idempotent' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface Bird
{
    public function chirp();
}
\class_alias('Phpactor202301\\Bird', 'Bird', \false);
class Foobar implements Bird
{
    public function chirp()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

interface Bird
{
    public function chirp();
}
\class_alias('Phpactor202301\\Bird', 'Bird', \false);
class Foobar implements Bird
{
    public function chirp()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
], 'It is adds after the last method' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface Bird
{
    public function chirp();
}
\class_alias('Phpactor202301\\Bird', 'Bird', \false);
class Foobar implements Bird
{
    public function hello()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

interface Bird
{
    public function chirp();
}
\class_alias('Phpactor202301\\Bird', 'Bird', \false);
class Foobar implements Bird
{
    public function hello()
    {
    }
    public function chirp()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
], 'It uses the short names' => [<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Animals\Sound;
interface Bird
{
    public function chirp() : Sound;
}
\class_alias('Phpactor202301\\Bird', 'Bird', \false);
class Foobar implements Bird
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Animals\Sound;
interface Bird
{
    public function chirp() : Sound;
}
\class_alias('Phpactor202301\\Bird', 'Bird', \false);
class Foobar implements Bird
{
    public function chirp() : Sound
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
], 'It implements abstract functions' => [<<<'EOT'
<?php

namespace Phpactor202301;

abstract class Bird
{
    public abstract function chirp();
}
\class_alias('Phpactor202301\\Bird', 'Bird', \false);
class Foobar extends Bird
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

abstract class Bird
{
    public abstract function chirp();
}
\class_alias('Phpactor202301\\Bird', 'Bird', \false);
class Foobar extends Bird
{
    public function chirp()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
], 'It implements methods from abstract class which implements an interface' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface Animal
{
    public abstract function jump();
}
\class_alias('Phpactor202301\\Animal', 'Animal', \false);
abstract class Bird implements Animal
{
}
\class_alias('Phpactor202301\\Bird', 'Bird', \false);
class Foobar extends Bird
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

interface Animal
{
    public abstract function jump();
}
\class_alias('Phpactor202301\\Animal', 'Animal', \false);
abstract class Bird implements Animal
{
}
\class_alias('Phpactor202301\\Bird', 'Bird', \false);
class Foobar extends Bird
{
    public function jump()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
], 'It ignores methods that already exist' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface Rabbit
{
    public function dig(int $depth = 5) : Dirt;
    public function foobar();
}
\class_alias('Phpactor202301\\Rabbit', 'Rabbit', \false);
class Foobar implements Rabbit
{
    public function dig(int $depth = 5) : Dirt
    {
    }
    public function foobar()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

interface Rabbit
{
    public function dig(int $depth = 5) : Dirt;
    public function foobar();
}
\class_alias('Phpactor202301\\Rabbit', 'Rabbit', \false);
class Foobar implements Rabbit
{
    public function dig(int $depth = 5) : Dirt
    {
    }
    public function foobar()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
], 'It imports use statements outside of the current namespace' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface Rabbit
{
    public function dig(Arg\Barg $depth = 5) : Barfoo\Dirt;
}
\class_alias('Phpactor202301\\Rabbit', 'Rabbit', \false);
class Foobar implements Rabbit
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Arg\Barg;
use Phpactor202301\Barfoo\Dirt;
interface Rabbit
{
    public function dig(Arg\Barg $depth = 5) : Barfoo\Dirt;
}
\class_alias('Phpactor202301\\Rabbit', 'Rabbit', \false);
class Foobar implements Rabbit
{
    public function dig(Barg $depth = 5) : Dirt
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
], 'It implements contracts with nullable return type' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface Animal
{
    public abstract function jump() : ?Arg\Foo;
}
\class_alias('Phpactor202301\\Animal', 'Animal', \false);
class Foobar implements Animal
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Arg\Foo;
interface Animal
{
    public abstract function jump() : ?Arg\Foo;
}
\class_alias('Phpactor202301\\Animal', 'Animal', \false);
class Foobar implements Animal
{
    public function jump() : ?Foo
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
], 'It uses "iterable"' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface Animal
{
    public abstract function jump() : iterable;
}
\class_alias('Phpactor202301\\Animal', 'Animal', \false);
class Foobar implements Animal
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, <<<'EOT'
<?php

namespace Phpactor202301;

interface Animal
{
    public abstract function jump() : iterable;
}
\class_alias('Phpactor202301\\Animal', 'Animal', \false);
class Foobar implements Animal
{
    public function jump() : iterable
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
]];
    }
    /**
     * @dataProvider provideDiagnostics
     */
    public function testDiagnostics(string $example, int $expectedCount) : void
    {
        $source = SourceCode::fromString($example);
        $transformer = new ImplementContracts($this->reflectorForWorkspace($example), $this->updater(), $this->builderFactory($this->reflectorForWorkspace($example)));
        $this->assertCount($expectedCount, $transformer->diagnostics($source));
    }
    /**
     * @return Generator<mixed>
     */
    public function provideDiagnostics() : Generator
    {
        (yield 'empty' => [<<<'EOT'
<?php


EOT
, 0]);
        (yield 'missing method' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface A
{
    public function barfoo() : void;
}
\class_alias('Phpactor202301\\A', 'A', \false);
class B implements A
{
}
\class_alias('Phpactor202301\\B', 'B', \false);
EOT
, 1]);
        (yield 'not missing method' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface A
{
    public function barfoo() : void;
}
\class_alias('Phpactor202301\\A', 'A', \false);
class B implements A
{
    public function barfoo()
    {
    }
}
\class_alias('Phpactor202301\\B', 'B', \false);
EOT
, 0]);
        (yield 'not missing method with trait' => [<<<'EOT'
<?php

abstract class A { abstract public function barfoo(): void; }

trait Foo {
    public function barfoo() {};
}

class B extends A
{
    use Foo;
}
EOT
, 0]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Tests\\Adapter\\WorseReflection\\Transformer\\ImplementContractsTest', 'Phpactor\\CodeTransform\\Tests\\Adapter\\WorseReflection\\Transformer\\ImplementContractsTest', \false);
