<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Integration\Bridge\TolerantParser\Reflection;

use Generator;
use Phpactor202301\Phpactor\WorseReflection\Tests\Integration\IntegrationTestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionInterface;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionConstant;
use Closure;
class ReflectionInterfaceTest extends IntegrationTestCase
{
    /**
     * @dataProvider provideReflectionInterface
     */
    public function testReflectInterface(string $source, string $class, Closure $assertion) : void
    {
        $class = $this->createReflector($source)->reflectClassLike(ClassName::fromString($class));
        $assertion($class);
    }
    /**
     * @return Generator<array{string,string,Closure(ReflectionInterface): void}>
     */
    public function provideReflectionInterface() : Generator
    {
        (yield 'It reflects an interface' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface Barfoo
{
}
\class_alias('Phpactor202301\\Barfoo', 'Barfoo', \false);
EOT
, 'Barfoo', function ($class) : void {
            $this->assertEquals('Barfoo', (string) $class->name()->short());
            $this->assertInstanceOf(ReflectionInterface::class, $class);
            $this->assertTrue($class->isInterface());
        }]);
        (yield 'It reflects a classes interfaces' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface Barfoo
{
}
\class_alias('Phpactor202301\\Barfoo', 'Barfoo', \false);
interface Bazbar
{
}
\class_alias('Phpactor202301\\Bazbar', 'Bazbar', \false);
class Foobar implements Barfoo, Bazbar
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function ($class) : void {
            $interfaces = $class->interfaces();
            $this->assertCount(2, $interfaces);
            $interface = $interfaces->get('Barfoo');
            $this->assertInstanceOf(ReflectionInterface::class, $interface);
        }]);
        (yield 'It reflects a class which implements an interface which extends other interfaces' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface Barfoo
{
}
\class_alias('Phpactor202301\\Barfoo', 'Barfoo', \false);
interface Zedboo
{
}
\class_alias('Phpactor202301\\Zedboo', 'Zedboo', \false);
interface Bazbar extends Barfoo, Zedboo
{
}
\class_alias('Phpactor202301\\Bazbar', 'Bazbar', \false);
EOT
, 'Bazbar', function ($class) : void {
            $interfaces = $class->parents();
            $this->assertCount(2, $interfaces);
            $interface = $interfaces->get('Barfoo');
            $this->assertInstanceOf(ReflectionInterface::class, $interface);
        }]);
        (yield 'It reflects inherited methods in an interface' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface Barfoo
{
    public function methodOne();
}
\class_alias('Phpactor202301\\Barfoo', 'Barfoo', \false);
interface Zedboo
{
    public function methodTwo();
}
\class_alias('Phpactor202301\\Zedboo', 'Zedboo', \false);
interface Bazbar extends Barfoo, Zedboo
{
}
\class_alias('Phpactor202301\\Bazbar', 'Bazbar', \false);
EOT
, 'Bazbar', function ($interface) : void {
            $this->assertInstanceOf(ReflectionInterface::class, $interface);
            $this->assertCount(2, $interface->methods());
        }]);
        (yield 'It reflect interface methods' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface Barfoo
{
    public function foobar();
}
\class_alias('Phpactor202301\\Barfoo', 'Barfoo', \false);
EOT
, 'Barfoo', function ($class) : void {
            $this->assertEquals('Barfoo', (string) $class->name()->short());
            $this->assertEquals(['foobar'], $class->methods()->keys());
        }]);
        (yield 'It interface constants' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface Int1
{
    const FOOBAR = 'foobar';
}
\class_alias('Phpactor202301\\Int1', 'Int1', \false);
interface Int2
{
    const FOOBAR = 'foobar';
    const BARFOO = 'barfoo';
}
\class_alias('Phpactor202301\\Int2', 'Int2', \false);
interface Int3 extends Int1, Int2
{
    const EEEBAR = 'eeebar';
}
\class_alias('Phpactor202301\\Int3', 'Int3', \false);
EOT
, 'Int3', function ($class) : void {
            $this->assertCount(3, $class->constants());
            $this->assertInstanceOf(ReflectionConstant::class, $class->constants()->get('FOOBAR'));
            $this->assertInstanceOf(ReflectionConstant::class, $class->constants()->get('EEEBAR'));
        }]);
        (yield 'instanceof' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface Interface1
{
}
\class_alias('Phpactor202301\\Interface1', 'Interface1', \false);
interface Interface2 extends Interface1
{
}
\class_alias('Phpactor202301\\Interface2', 'Interface2', \false);
EOT
, 'Interface2', function ($class) : void {
            $this->assertTrue($class->isInstanceOf(ClassName::fromString('Interface2')));
            $this->assertTrue($class->isInstanceOf(ClassName::fromString('Interface1')));
            $this->assertFalse($class->isInstanceOf(ClassName::fromString('Interface3')));
        }]);
        (yield 'Method class is of context class, not declaration class' => [<<<'EOT'
<?php

namespace Phpactor202301\Acme;

interface Barfoo
{
    function method1()
    {
    }
}
interface Foobar extends Barfoo
{
}
EOT
, 'Phpactor202301\\Acme\\Foobar', function (ReflectionInterface $class) : void {
            $this->assertEquals('Phpactor202301\\Acme\\Foobar', (string) $class->methods()->get('method1')->class()->name());
            $this->assertEquals('Phpactor202301\\Acme\\Barfoo', (string) $class->methods()->get('method1')->declaringClass()->name());
        }]);
        (yield 'Returns all members' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface Class1
{
    private const FOOBAR = 'foobar';
    private function foobar()
    {
    }
}
\class_alias('Phpactor202301\\Class1', 'Class1', \false);

EOT
, 'Class1', function (ReflectionInterface $class) : void {
            $this->assertCount(2, $class->members());
            $this->assertTrue($class->members()->has('FOOBAR'));
            $this->assertTrue($class->members()->has('foobar'));
        }]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\TolerantParser\\Reflection\\ReflectionInterfaceTest', 'Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\TolerantParser\\Reflection\\ReflectionInterfaceTest', \false);
