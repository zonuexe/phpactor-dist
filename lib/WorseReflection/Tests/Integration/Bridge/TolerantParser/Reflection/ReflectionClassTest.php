<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Integration\Bridge\TolerantParser\Reflection;

use Generator;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\UnionType;
use Phpactor202301\Phpactor\WorseReflection\Core\Visibility;
use Phpactor202301\Phpactor\WorseReflection\Tests\Integration\IntegrationTestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Phpactor\WorseReflection\Core\Name;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClass;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionConstant;
use Phpactor202301\Phpactor\WorseReflection\Core\NameImports;
use Closure;
class ReflectionClassTest extends IntegrationTestCase
{
    public function testExceptionOnClassNotFound() : void
    {
        $this->expectException(\Phpactor202301\Phpactor\WorseReflection\Core\Exception\ClassNotFound::class);
        $this->createReflector('')->reflectClassLike(ClassName::fromString('Foobar'));
    }
    /**
     * @dataProvider provideReflectionClass
     */
    public function testReflectClass(string $source, string $class, Closure $assertion) : void
    {
        $class = $this->createReflector($source)->reflectClassLike(ClassName::fromString($class));
        $assertion($class);
    }
    /**
     * @return Generator<string,array{string,string,Closure(ReflectionClass): void}>
     */
    public function provideReflectionClass() : Generator
    {
        (yield 'It reflects an empty class' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function ($class) : void {
            $this->assertEquals('Foobar', (string) $class->name()->short());
            $this->assertInstanceOf(ReflectionClass::class, $class);
            $this->assertFalse($class->isInterface());
        }]);
        (yield 'It reflects a class which extends another' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Barfoo
{
}
\class_alias('Phpactor202301\\Barfoo', 'Barfoo', \false);
class Foobar extends Barfoo
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function ($class) : void {
            $this->assertEquals('Foobar', (string) $class->name()->short());
            $this->assertEquals('Barfoo', (string) $class->parent()->name()->short());
        }]);
        (yield 'It reflects class constants' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Class1
{
    const EEEBAR = 'eeebar';
}
\class_alias('Phpactor202301\\Class1', 'Class1', \false);
class Class2 extends Class1
{
    const FOOBAR = 'foobar';
    const BARFOO = 'barfoo';
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function ($class) : void {
            $this->assertCount(3, $class->constants());
            $this->assertInstanceOf(ReflectionConstant::class, $class->constants()->get('FOOBAR'));
            $this->assertInstanceOf(ReflectionConstant::class, $class->constants()->get('EEEBAR'));
        }]);
        (yield 'It can provide the name of its last member' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Class2
{
    private $foo;
    private $bar;
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function ($class) : void {
            $this->assertEquals('bar', $class->properties()->last()->name());
        }]);
        (yield 'It can provide the name of its first member' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Class2
{
    private $foo;
    private $bar;
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function ($class) : void {
            $this->assertEquals('foo', $class->properties()->first()->name());
        }]);
        (yield 'It can provide its position' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Class2
{
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function ($class) : void {
            $this->assertEquals(7, $class->position()->start());
        }]);
        (yield 'It can provide the position of its member declarations' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Class2
{
    private $foobar;
    private $barfoo;
    public function zed()
    {
    }
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function ($class) : void {
            $this->assertEquals(20, $class->memberListPosition()->start());
        }]);
        (yield 'It provides list of its interfaces' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface InterfaceOne
{
}
\class_alias('Phpactor202301\\InterfaceOne', 'InterfaceOne', \false);
class Class2 implements InterfaceOne
{
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function ($class) : void {
            $this->assertEquals(1, $class->interfaces()->count());
            $this->assertEquals('InterfaceOne', $class->interfaces()->first()->name());
        }]);
        (yield 'It list of interfaces includes interfaces from parent classes' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface InterfaceOne
{
}
\class_alias('Phpactor202301\\InterfaceOne', 'InterfaceOne', \false);
class Class1 implements InterfaceOne
{
}
\class_alias('Phpactor202301\\Class1', 'Class1', \false);
class Class2 extends Class1
{
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function ($class) : void {
            $this->assertEquals(1, $class->interfaces()->count());
            $this->assertEquals('InterfaceOne', $class->interfaces()->first()->name());
        }]);
        (yield 'It provides list of its traits' => [<<<'EOT'
<?php

namespace Phpactor202301;

trait TraitNUMBERone
{
}
trait TraitNUMBERtwo
{
}
class Class2
{
    use TraitNUMBERone;
    use TraitNUMBERtwo;
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function (ReflectionClass $class) : void {
            $this->assertEquals(2, $class->traits()->count());
            $this->assertEquals('TraitNUMBERone', $class->traits()->get('TraitNUMBERone')->name());
            $this->assertEquals('TraitNUMBERtwo', $class->traits()->get('TraitNUMBERtwo')->name());
        }]);
        (yield 'Traits are inherited from parent classes (?)' => [<<<'EOT'
<?php

namespace Phpactor202301;

trait TraitNUMBERone
{
}
class Class2
{
    use TraitNUMBERone;
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);
class Class1 extends Class2
{
}
\class_alias('Phpactor202301\\Class1', 'Class1', \false);

EOT
, 'Class1', function ($class) : void {
            $this->assertEquals(1, $class->traits()->count());
            $this->assertEquals('TraitNUMBERone', $class->traits()->first()->name());
        }]);
        (yield 'Get methods includes trait methods' => [<<<'EOT'
<?php

namespace Phpactor202301;

trait TraitNUMBERone
{
    public function traitMethod1()
    {
    }
}
trait TraitNUMBERtwo
{
    public function traitMethod2()
    {
    }
}
class Class2
{
    use TraitNUMBERone, TraitNUMBERtwo;
    public function notATrait()
    {
    }
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function ($class) : void {
            $this->assertEquals(3, $class->methods()->count());
            $this->assertTrue($class->methods()->has('traitMethod1'));
            $this->assertTrue($class->methods()->has('traitMethod2'));
        }]);
        (yield 'Tolerates not found traits' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Class2
{
    use TraitNUMBERone, TraitNUMBERtwo;
    public function notATrait()
    {
    }
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function ($class) : void {
            $this->assertEquals(1, $class->methods()->count());
        }]);
        (yield 'Get methods includes aliased trait methods' => [<<<'EOT'
<?php

namespace Phpactor202301;

trait TraitOne
{
    public function one()
    {
    }
    public function three()
    {
    }
    public function four()
    {
    }
}
class Class2
{
    use TraitOne {
        one as private two;
        three as protected three;
    }
    public function one()
    {
    }
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function (ReflectionClass $class) : void {
            $this->assertEquals(4, $class->methods()->count());
            $this->assertTrue($class->methods()->has('one'));
            $this->assertTrue($class->methods()->has('two'));
            $this->assertTrue($class->methods()->has('three'));
            $this->assertTrue($class->methods()->has('four'));
            $this->assertEquals(Visibility::private(), $class->methods()->get('two')->visibility());
            $this->assertEquals(Visibility::protected(), $class->methods()->get('three')->visibility());
            $this->assertFalse($class->methods()->belongingTo(ClassName::fromString('Class2'))->has('two'));
            $this->assertEquals('TraitOne', $class->methods()->get('two')->declaringClass()->name()->short());
        }]);
        (yield 'Get methods includes namespaced aliased trait methods' => [<<<'EOT'
<?php

namespace Phpactor202301\Bar;

trait TraitOne
{
    public function one()
    {
    }
    public function three()
    {
    }
}
class Class2
{
    use \Phpactor202301\Bar\TraitOne {
        one as private two;
        three as protected three;
    }
    public function one()
    {
    }
}

EOT
, 'Phpactor202301\\Bar\\Class2', function (ReflectionClass $class) : void {
            $this->assertEquals(3, $class->methods()->count());
            $this->assertTrue($class->methods()->has('one'));
            $this->assertTrue($class->methods()->has('three'));
        }]);
        (yield 'Get trait properties' => [<<<'EOT'
<?php

namespace Phpactor202301;

trait TraitNUMBERone
{
    private $prop1;
}
class Class2
{
    use TraitNUMBERone;
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function ($class) : void {
            $this->assertEquals(1, $class->properties()->count());
            $this->assertEquals('prop1', $class->properties()->first()->name());
        }]);
        (yield 'Get methods at offset' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Class2
{
    public function notATrait()
    {
    }
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function ($class) : void {
            $this->assertEquals(1, $class->methods()->atOffset(27)->count());
        }]);
        (yield 'Get properties includes trait properties' => [<<<'EOT'
<?php

namespace Phpactor202301;

trait TraitNUMBERone
{
    public $foobar;
}
class Class2
{
    use TraitNUMBERone;
    private $notAFoobar;
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function (ReflectionClass $class) : void {
            $this->assertEquals(2, $class->properties()->count());
            $this->assertEquals('foobar', $class->properties()->first()->name());
        }]);
        (yield 'Get properties for belonging to' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Class1
{
    public $foobar;
}
\class_alias('Phpactor202301\\Class1', 'Class1', \false);
class Class2 extends Class1
{
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function ($class) : void {
            $this->assertCount(1, $class->properties()->belongingTo(ClassName::fromString('Class1')));
            $this->assertCount(0, $class->properties()->belongingTo(ClassName::fromString('Class2')));
        }]);
        (yield 'If it extends an interface, then ignore' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface SomeInterface
{
}
\class_alias('Phpactor202301\\SomeInterface', 'SomeInterface', \false);
class Class2 extends SomeInterface
{
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function ($class) : void {
            $this->assertEquals(0, $class->methods()->count());
        }]);
        (yield 'isInstanceOf returns false when it is not an instance of' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Class2
{
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function ($class) : void {
            $this->assertFalse($class->isInstanceOf(ClassName::fromString('Foobar')));
        }]);
        (yield 'isInstanceOf returns true for itself' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Class2
{
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function ($class) : void {
            $this->assertTrue($class->isInstanceOf(ClassName::fromString('Class2')));
        }]);
        (yield 'isInstanceOf returns true when it is not an instance of an interface' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface SomeInterface
{
}
\class_alias('Phpactor202301\\SomeInterface', 'SomeInterface', \false);
class Class2 implements SomeInterface
{
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function ($class) : void {
            $this->assertTrue($class->isInstanceOf(ClassName::fromString('SomeInterface')));
        }]);
        (yield 'isInstanceOf returns true when a class implements the interface and has a parent' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface SomeInterface
{
}
\class_alias('Phpactor202301\\SomeInterface', 'SomeInterface', \false);
class ParentClass
{
}
\class_alias('Phpactor202301\\ParentClass', 'ParentClass', \false);
class Class2 extends ParentClass implements SomeInterface
{
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function ($class) : void {
            $this->assertTrue($class->isInstanceOf(ClassName::fromString('SomeInterface')));
        }]);
        (yield 'isInstanceOf returns true for a parent class' => [<<<'EOT'
<?php

namespace Phpactor202301;

class SomeParent
{
}
\class_alias('Phpactor202301\\SomeParent', 'SomeParent', \false);
class Class2 extends SomeParent
{
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function ($class) : void {
            $this->assertTrue($class->isInstanceOf(ClassName::fromString('SomeParent')));
        }]);
        (yield 'Returns source code' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Class2
{
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function ($class) : void {
            $this->assertStringContainsString('class Class2', (string) $class->sourceCode());
        }]);
        (yield 'Returns imported classes' => [<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Foobar\Barfoo;
use Phpactor202301\Barfoo\Foobaz as Carzatz;
class Class2
{
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function ($class) : void {
            $this->assertEquals(NameImports::fromNames(['Barfoo' => Name::fromString('Phpactor202301\\Foobar\\Barfoo'), 'Carzatz' => Name::fromString('Phpactor202301\\Barfoo\\Foobaz')]), $class->scope()->nameImports());
        }]);
        (yield 'Inherits constants from interface' => [<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Foobar\Barfoo;
use Phpactor202301\Barfoo\Foobaz as Carzatz;
interface SomeInterface
{
    const SOME_CONSTANT = 'foo';
}
\class_alias('Phpactor202301\\SomeInterface', 'SomeInterface', \false);
class Class2 implements SomeInterface
{
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function (ReflectionClass $class) : void {
            $this->assertCount(1, $class->constants());
            $this->assertEquals('SOME_CONSTANT', $class->constants()->get('SOME_CONSTANT')->name());
        }]);
        (yield 'Returns all members' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Class1
{
    private const FOOBAR = 'foobar';
    private $foo;
    private function foobar()
    {
    }
}
\class_alias('Phpactor202301\\Class1', 'Class1', \false);

EOT
, 'Class1', function (ReflectionClass $class) : void {
            $this->assertCount(3, $class->members());
            $this->assertTrue($class->members()->has('FOOBAR'));
            $this->assertTrue($class->members()->has('foobar'));
            $this->assertTrue($class->members()->has('foo'));
        }]);
        (yield 'Incomplete extends' => [<<<'EOT'
<?php

class Class1 extends
{
}

EOT
, 'Class1', function (ReflectionClass $class) : void {
            $this->assertNull($class->parent());
            $this->assertEquals('Class1', $class->name()->short());
        }]);
        (yield 'Does not infinite loop with self-referencing class on get interfaces' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Class1 extends Class1
{
}
\class_alias('Phpactor202301\\Class1', 'Class1', \false);

EOT
, 'Class1', function (ReflectionClass $class) : void {
            $this->assertCount(0, $class->interfaces());
        }]);
        (yield 'Says if class is abstract' => [<<<'EOT'
<?php

namespace Phpactor202301;

abstract class Class1
{
}
\class_alias('Phpactor202301\\Class1', 'Class1', \false);

EOT
, 'Class1', function (ReflectionClass $class) : void {
            $this->assertTrue($class->isAbstract());
        }]);
        (yield 'Says if class is not abstract' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Class1
{
}
\class_alias('Phpactor202301\\Class1', 'Class1', \false);

EOT
, 'Class1', function (ReflectionClass $class) : void {
            $this->assertFalse($class->isAbstract());
        }]);
        (yield 'Says if class is final' => [<<<'EOT'
<?php

namespace Phpactor202301;

final class Class1
{
}
\class_alias('Phpactor202301\\Class1', 'Class1', \false);

EOT
, 'Class1', function (ReflectionClass $class) : void {
            $this->assertTrue($class->isFinal());
        }]);
        (yield 'Says if class is deprecated' => [<<<'EOT'
<?php

namespace Phpactor202301;

/**
 * @deprecated Foobar yes
 */
final class Class1
{
}
/**
 * @deprecated Foobar yes
 */
\class_alias('Phpactor202301\\Class1', 'Class1', \false);

EOT
, 'Class1', function (ReflectionClass $class) : void {
            $this->assertTrue($class->deprecation()->isDefined());
        }]);
    }
    /**
     * @dataProvider provideVirtualMethods
     */
    public function testVirtualMethods(string $source, string $class, Closure $assertion) : void
    {
        $class = $this->createReflector($source)->reflectClassLike(ClassName::fromString($class));
        $assertion($class);
    }
    /**
     * @return Generator<string,array{string,string,Closure(ReflectionClass): void}>
     */
    public function provideVirtualMethods() : Generator
    {
        (yield 'virtual methods' => [<<<'EOT'
<?php

namespace Phpactor202301;

/**
 * @method \Foobar foobar()
 * @method \Foobar barfoo()
 */
class Class1
{
}
/**
 * @method \Foobar foobar()
 * @method \Foobar barfoo()
 */
\class_alias('Phpactor202301\\Class1', 'Class1', \false);

EOT
, 'Class1', function ($class) : void {
            $this->assertEquals(2, $class->methods()->count());
            $this->assertEquals('foobar', $class->methods()->first()->name());
        }]);
        (yield 'virtual methods merge onto existing ones' => [<<<'EOT'
<?php

namespace Phpactor202301;

/**
 * @method \Foobar foobar()
 */
class Class1
{
    public function foobar() : \Phpactor202301\Barfoo
    {
    }
}
/**
 * @method \Foobar foobar()
 */
\class_alias('Phpactor202301\\Class1', 'Class1', \false);

EOT
, 'Class1', function (ReflectionClass $class) : void {
            $this->assertCount(1, $class->methods());
            // originally this returned the declared type
            $this->assertEquals('Foobar', $class->methods()->first()->type()->__toString());
            $this->assertEquals('Foobar', $class->methods()->first()->inferredType()->__toString());
        }]);
        (yield 'virtual methods are inherited' => [<<<'EOT'
<?php

namespace Phpactor202301;

/** @method \Foobar foobar() */
class Class1
{
}
/** @method \Foobar foobar() */
\class_alias('Phpactor202301\\Class1', 'Class1', \false);
class Class2 extends Class1
{
    public function foo()
    {
    }
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function (ReflectionClass $class) : void {
            $this->assertCount(2, $class->methods());
            $this->assertEquals('Foobar', $class->methods()->get('foobar')->inferredType()->__toString());
        }]);
        (yield 'virtual methods are inherited from interface' => [<<<'EOT'
<?php

namespace Phpactor202301;

/** @method \Foobar foobar() */
interface Class1
{
}
/** @method \Foobar foobar() */
\class_alias('Phpactor202301\\Class1', 'Class1', \false);
class Class2 implements Class1
{
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function (ReflectionClass $class) : void {
            $this->assertCount(1, $class->methods());
            $this->assertEquals('Foobar', $class->methods()->get('foobar')->inferredType()->__toString());
        }]);
        (yield 'virtual methods are inherited from multiple layers of interfaces' => [<<<'EOT'
<?php

namespace Phpactor202301;

/** @method \Foobar foobar() */
interface Class3
{
}
/** @method \Foobar foobar() */
\class_alias('Phpactor202301\\Class3', 'Class3', \false);
interface Class1 extends Class3
{
}
\class_alias('Phpactor202301\\Class1', 'Class1', \false);
class Class2 implements Class1
{
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function (ReflectionClass $class) : void {
            $this->assertCount(1, $class->methods());
            $this->assertEquals('Foobar', $class->methods()->get('foobar')->inferredType()->__toString());
        }]);
        (yield 'virtual methods are inherited from parent class which implements interface' => [<<<'EOT'
<?php

namespace Phpactor202301;

/** @method \Foobar foobar() */
interface ParentInterface
{
}
/** @method \Foobar foobar() */
\class_alias('Phpactor202301\\ParentInterface', 'ParentInterface', \false);
class ParentClass implements ParentInterface
{
}
\class_alias('Phpactor202301\\ParentClass', 'ParentClass', \false);
class Class2 extends ParentClass
{
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function (ReflectionClass $class) : void {
            $this->assertCount(1, $class->methods());
            $this->assertEquals('Foobar', $class->methods()->get('foobar')->inferredType()->__toString());
            $this->assertEquals('ParentInterface', $class->methods()->get('foobar')->declaringClass()->name()->__toString());
        }]);
        (yield 'virtual method types can be relative' => ['<?php namespace Bosh { /** @method Foobar foobar() */ class Class1 {}', 'Phpactor202301\\Bosh\\Class1', function (ReflectionClass $class) : void {
            $this->assertEquals('Phpactor202301\\Bosh\\Foobar', $class->methods()->get('foobar')->inferredType()->__toString());
        }]);
        (yield 'virtual method types can be absolute' => ['<?php namespace Bosh { /** @method \\Foobar foobar() */ class Class1 {}', 'Phpactor202301\\Bosh\\Class1', function (ReflectionClass $class) : void {
            $this->assertEquals('Foobar', $class->methods()->get('foobar')->inferredType()->__toString());
        }]);
        (yield 'virtual methods of child classes override those of parents' => [<<<'EOT'
<?php

namespace Phpactor202301;

/** @method \Foobar foobar() */
class Class1
{
}
/** @method \Foobar foobar() */
\class_alias('Phpactor202301\\Class1', 'Class1', \false);
/** @method \Barfoo foobar() */
class Class2 extends Class1
{
    public function foo()
    {
    }
}
/** @method \Barfoo foobar() */
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function (ReflectionClass $class) : void {
            $this->assertCount(2, $class->methods());
            $this->assertEquals('Barfoo', $class->methods()->get('foobar')->inferredType()->__toString());
        }]);
        (yield 'virtual methods are extracted from traits' => [<<<'EOT'
<?php

namespace Phpactor202301;

/**
 * @method \Foobar foobar()
 */
trait Trait1
{
}
class Class1
{
    use Trait1;
}
\class_alias('Phpactor202301\\Class1', 'Class1', \false);

EOT
, 'Class1', function (ReflectionClass $class) : void {
            $this->assertCount(1, $class->methods());
            $this->assertEquals('Foobar', $class->methods()->first()->inferredType()->__toString());
        }]);
        (yield 'virtual methods are extracted from traits of a parent class' => [<<<'EOT'
<?php

namespace Phpactor202301;

/**
 * @method \Foobar foobar()
 */
trait Trait1
{
}
class Class2
{
    use Trait1;
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);
class Class1 extends Class2
{
}
\class_alias('Phpactor202301\\Class1', 'Class1', \false);

EOT
, 'Class1', function (ReflectionClass $class) : void {
            $this->assertCount(1, $class->methods());
            $this->assertEquals('Foobar', $class->methods()->first()->inferredType()->__toString());
        }]);
    }
    /**
     * @dataProvider provideVirtualProperties
     */
    public function testVirtualProperties(string $source, string $class, Closure $assertion) : void
    {
        $class = $this->createReflector($source)->reflectClassLike(ClassName::fromString($class));
        $assertion($class);
    }
    /**
     * @return Generator<string,array{string,string,Closure(ReflectionClass): void}>
     */
    public function provideVirtualProperties() : Generator
    {
        (yield 'virtual properties' => [<<<'EOT'
<?php

namespace Phpactor202301;

/**
 * @property \Foobar $foobar
 * @property \Foobar $barfoo
 */
class Class1
{
}
/**
 * @property \Foobar $foobar
 * @property \Foobar $barfoo
 */
\class_alias('Phpactor202301\\Class1', 'Class1', \false);

EOT
, 'Class1', function ($class) : void {
            $this->assertEquals(2, $class->properties()->count());
            $this->assertEquals('foobar', $class->properties()->first()->name());
        }]);
        (yield 'invalid properties' => [<<<'EOT'
<?php

namespace Phpactor202301;

/**
 * @property $foobar
 * @property
 */
class Class1
{
}
/**
 * @property $foobar
 * @property
 */
\class_alias('Phpactor202301\\Class1', 'Class1', \false);

EOT
, 'Class1', function (ReflectionClass $class) : void {
            $this->assertEquals(2, $class->properties()->count());
        }]);
        (yield 'multiple types' => [<<<'EOT'
<?php

namespace Phpactor202301;

/**
 * @property string|int $foobar
 */
class Class1
{
}
/**
 * @property string|int $foobar
 */
\class_alias('Phpactor202301\\Class1', 'Class1', \false);

EOT
, 'Class1', function (ReflectionClass $class) : void {
            $this->assertEquals(1, $class->properties()->count());
            self::assertInstanceOf(UnionType::class, $class->properties()->first()->type());
            self::assertEquals('string|int', $class->properties()->first()->type());
        }]);
        (yield 'virtual properties are extracted from traits' => [<<<'EOT'
<?php

namespace Phpactor202301;

/**
 * @property \Foobar $foobar
 * @property \Barfoo $barfoo
 */
trait Trait1
{
}
class Class1
{
    use Trait1;
}
\class_alias('Phpactor202301\\Class1', 'Class1', \false);

EOT
, 'Class1', function (ReflectionClass $class) : void {
            $this->assertEquals(2, $class->properties()->count());
            $this->assertEquals('foobar', $class->properties()->first()->name());
            $this->assertEquals('Foobar', $class->properties()->first()->inferredType()->__toString());
            $this->assertEquals('barfoo', $class->properties()->last()->name());
            $this->assertEquals('Barfoo', $class->properties()->last()->inferredType()->__toString());
        }]);
        (yield 'virtual properties are extracted from traits of a parent class' => [<<<'EOT'
<?php

namespace Phpactor202301;

/**
 * @property \Foobar $foobar
 * @property \Barfoo $barfoo
 */
trait Trait1
{
}
class Class2
{
    use Trait1;
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);
class Class1 extends Class2
{
}
\class_alias('Phpactor202301\\Class1', 'Class1', \false);

EOT
, 'Class1', function (ReflectionClass $class) : void {
            $this->assertEquals(2, $class->properties()->count());
            $this->assertEquals('foobar', $class->properties()->first()->name());
            $this->assertEquals('Foobar', $class->properties()->first()->inferredType()->__toString());
            $this->assertEquals('barfoo', $class->properties()->last()->name());
            $this->assertEquals('Barfoo', $class->properties()->last()->inferredType()->__toString());
        }]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\TolerantParser\\Reflection\\ReflectionClassTest', 'Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\TolerantParser\\Reflection\\ReflectionClassTest', \false);