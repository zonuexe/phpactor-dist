<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Integration\Bridge\TolerantParser\Reflection;

use Phpactor202301\Phpactor\WorseReflection\Tests\Integration\IntegrationTestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClass;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionConstantCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Visibility;
use Closure;
class ReflectionConstantTest extends IntegrationTestCase
{
    /**
     * @dataProvider provideReflectionConstant
     */
    public function testReflectConstant(string $source, string $class, Closure $assertion) : void
    {
        $class = $this->createReflector($source)->reflectClassLike(ClassName::fromString($class));
        \assert($class instanceof ReflectionClass);
        $assertion($class->constants());
    }
    public function provideReflectionConstant()
    {
        (yield 'Returns declaring class' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    const FOOBAR = 'foobar';
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function (ReflectionConstantCollection $constants) : void {
            $this->assertEquals('Foobar', $constants->get('FOOBAR')->declaringClass()->name()->__toString());
            $this->assertEquals(Visibility::public(), $constants->first()->visibility());
        }]);
        (yield 'Returns original member' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Barfoo
{
    const FOOBAR = 'foobar';
}
\class_alias('Phpactor202301\\Barfoo', 'Barfoo', \false);
class Foobar extends Barfoo
{
    const FOOBAR = 'foobar';
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function (ReflectionConstantCollection $constants) : void {
            $this->assertEquals('Barfoo', $constants->get('FOOBAR')->original()->declaringClass()->name()->__toString());
            $this->assertEquals(Visibility::public(), $constants->first()->visibility());
        }]);
        (yield 'Returns visibility' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    private const FOOBAR = 'foobar';
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function (ReflectionConstantCollection $constants) : void {
            $this->assertEquals(Visibility::private(), $constants->first()->visibility());
        }]);
        (yield 'Returns docblock' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /** Hello! */
    private const FOOBAR = 'foobar';
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function (ReflectionConstantCollection $constants) : void {
            $this->assertStringContainsString('/** Hello! */', $constants->first()->docblock()->raw());
        }]);
        (yield 'Returns type' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    const FOOBAR = 'foobar';
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function (ReflectionConstantCollection $constants) : void {
            $this->assertEquals('"foobar"', $constants->first()->type()->__toString());
        }]);
        (yield 'Doesnt return inferred retutrn types (not implemented)' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /** @var int */
    const FOOBAR = 'foobar';
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function (ReflectionConstantCollection $constants) : void {
            $this->assertEquals('"foobar"', $constants->first()->inferredType());
        }]);
        (yield 'Delimited constant list' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    const FOOBAR = 'foobar', BARFOO = 'barfoo';
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function (ReflectionConstantCollection $constants) : void {
            $this->assertCount(2, $constants);
        }]);
        (yield 'returns value' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    const FOOBAR = 'foobar';
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function (ReflectionConstantCollection $constants) : void {
            $constant = $constants->first();
            self::assertEquals('foobar', $constant->value());
        }]);
        (yield 'array value' => [<<<'EOT'
<?php

class Foobar
{
    const FOOBAR = ['one', 'two']';
}
EOT
, 'Foobar', function (ReflectionConstantCollection $constants) : void {
            $constant = $constants->first();
            self::assertEquals(['one', 'two'], $constant->value());
        }]);
        (yield 'no value' => [<<<'EOT'
<?php

class Foobar
{
    const FOOBAR = null';
}
EOT
, 'Foobar', function (ReflectionConstantCollection $constants) : void {
            $constant = $constants->first();
            self::assertEquals(null, $constant->value());
        }]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\TolerantParser\\Reflection\\ReflectionConstantTest', 'Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\TolerantParser\\Reflection\\ReflectionConstantTest', \false);
