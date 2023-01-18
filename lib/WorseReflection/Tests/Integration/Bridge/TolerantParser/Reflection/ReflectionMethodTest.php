<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Integration\Bridge\TolerantParser\Reflection;

use Generator;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMethodCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\UnionType;
use Phpactor202301\Phpactor\WorseReflection\Tests\Assert\TrinaryAssert;
use Phpactor202301\Phpactor\WorseReflection\Tests\Integration\IntegrationTestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Phpactor\WorseReflection\Core\Visibility;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMethod;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClass;
use Phpactor202301\Psr\Log\LoggerInterface;
use Closure;
class ReflectionMethodTest extends IntegrationTestCase
{
    use TrinaryAssert;
    /**
     * @dataProvider provideReflectionMethod
     * @dataProvider provideGenerics
     * @dataProvider provideDeprecations
     */
    public function testReflectMethod(string $source, string $class, Closure $assertion) : void
    {
        $class = $this->createReflector($source)->reflectClassLike(ClassName::fromString($class));
        $assertion($class->methods(), $this->logger());
    }
    public function provideReflectionMethod()
    {
        (yield 'It reflects a method' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function method();
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function ($methods) : void {
            $this->assertEquals('method', $methods->get('method')->name());
            $this->assertInstanceOf(ReflectionMethod::class, $methods->get('method'));
        }]);
        (yield 'Private visibility' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    private function method();
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function ($methods) : void {
            $this->assertEquals(Visibility::private(), $methods->get('method')->visibility());
        }]);
        (yield 'Protected visibility' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    protected function method()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function ($methods) : void {
            $this->assertEquals(Visibility::protected(), $methods->get('method')->visibility());
        }]);
        (yield 'Public visibility' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function method();
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function ($methods) : void {
            $this->assertEquals(Visibility::public(), $methods->get('method')->visibility());
        }]);
        (yield 'Union type' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    function method1() : string|int
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function (ReflectionMethodCollection $methods) : void {
            $this->assertEquals(new UnionType(TypeFactory::string(), TypeFactory::int()), $methods->get('method1')->inferredType());
        }]);
        (yield 'Return type' => [<<<'EOT'
<?php

namespace Phpactor202301\Test;

use Phpactor202301\Acme\Post;
class Foobar
{
    function method1() : int
    {
    }
    function method2() : string
    {
    }
    function method3() : float
    {
    }
    function method4() : array
    {
    }
    function method5() : Barfoo
    {
    }
    function method6() : Post
    {
    }
    function method7() : self
    {
    }
    function method8() : iterable
    {
    }
    function method9() : callable
    {
    }
    function method10() : resource
    {
    }
}
EOT
, 'Phpactor202301\\Test\\Foobar', function ($methods) : void {
            $this->assertEquals(TypeFactory::int(), $methods->get('method1')->returnType());
            $this->assertEquals(TypeFactory::string(), $methods->get('method2')->returnType());
            $this->assertEquals(TypeFactory::float(), $methods->get('method3')->returnType());
            $this->assertEquals(TypeFactory::array(), $methods->get('method4')->returnType());
            $this->assertEquals(ClassName::fromString('Phpactor202301\\Test\\Barfoo'), $methods->get('method5')->returnType()->name);
            $this->assertEquals(ClassName::fromString('Phpactor202301\\Acme\\Post'), $methods->get('method6')->returnType()->name);
            $this->assertEquals(ClassName::fromString('Phpactor202301\\Test\\Foobar'), $methods->get('method7')->returnType()->name);
            $this->assertEquals(TypeFactory::iterable(), $methods->get('method8')->returnType());
            $this->assertEquals(TypeFactory::callable(), $methods->get('method9')->returnType());
            $this->assertEquals(TypeFactory::resource(), $methods->get('method10')->returnType());
        }]);
        (yield 'Nullable return type' => [<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Acme\Post;
class Foobar
{
    function method1() : ?int
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function ($methods) : void {
            $this->assertEquals(TypeFactory::fromString('?int'), $methods->get('method1')->returnType());
        }]);
        (yield 'Inherited methods' => [<<<'EOT'
<?php

namespace Phpactor202301;

class ParentParentClass extends NonExisting
{
    public function method5()
    {
    }
}
\class_alias('Phpactor202301\\ParentParentClass', 'ParentParentClass', \false);
class ParentClass extends ParentParentClass
{
    private function method1()
    {
    }
    protected function method2()
    {
    }
    public function method3()
    {
    }
    public function method4()
    {
    }
}
\class_alias('Phpactor202301\\ParentClass', 'ParentClass', \false);
class Foobar extends ParentClass
{
    public function method4()
    {
    }
    // overrides from previous
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function (ReflectionMethodCollection $methods) : void {
            $this->assertEquals(['method5', 'method2', 'method3', 'method4'], $methods->keys());
            self::assertEquals('Foobar', $methods->get('method5')->class()->name()->head()->__toString());
        }]);
        (yield 'Return type from docblock' => [<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Acme\Post;
class Foobar
{
    /**
     * @return Post
     */
    function method1()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function ($methods) : void {
            $this->assertEquals('Phpactor202301\\Acme\\Post', $methods->get('method1')->inferredType()->__toString());
        }]);
        (yield 'Return type from array docblock' => [<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Acme\Post;
class Foobar
{
    /**
     * @return Post[]
     */
    function method1() : array
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function ($methods) : void {
            $this->assertEquals('Acme\\Post[]', $methods->get('method1')->inferredType()->__toString());
        }]);
        (yield 'Return type from docblock this and static' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * @return $this
     */
    function method1()
    {
    }
    /**
     * @return static
     */
    function method2()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function ($methods) : void {
            $this->assertEquals('$this(Foobar)', $methods->get('method1')->inferredType()->__toString(), '$this(Foobar)');
            $this->assertEquals('static(Foobar)', $methods->get('method2')->inferredType()->__toString(), 'static(Foobar)');
        }]);
        (yield 'Return type from docblock this and static from a trait' => [<<<'EOT'
<?php

namespace Phpactor202301;

trait FooTrait
{
    /**
     * @return $this
     */
    function method1()
    {
    }
    /**
     * @return static
     */
    function method2()
    {
    }
}
class Foobar
{
    use FooTrait;
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function ($methods) : void {
            $this->assertEquals('$this(Foobar)', $methods->get('method1')->inferredType()->__toString());
            $this->assertEquals('static(Foobar)', $methods->get('method2')->inferredType()->__toString());
        }]);
        (yield 'Return type from class @method annotation' => [<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Acme\Post;
/**
 * @method Post method1()
 */
class Foobar
{
    function method1()
    {
    }
}
/**
 * @method Post method1()
 */
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function ($methods) : void {
            self::assertTrinaryTrue(TypeFactory::class(ClassName::fromString('Phpactor202301\\Acme\\Post'))->is($methods->get('method1')->inferredType()));
        }]);
        (yield 'Return type from overridden @method annotation' => [<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Acme\Post;
class Barfoo
{
    /**
     * @return AbstractPost
     */
    function method1()
    {
    }
}
\class_alias('Phpactor202301\\Barfoo', 'Barfoo', \false);
/**
 * @method Post method1()
 */
class Foobar extends Barfoo
{
}
/**
 * @method Post method1()
 */
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function ($methods) : void {
            self::assertTrinaryTrue(TypeFactory::class(ClassName::fromString('Phpactor202301\\Acme\\Post'))->is($methods->get('method1')->inferredType()));
        }]);
        (yield 'Return type from inherited docblock' => [<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Acme\Post;
class ParentClass
{
    /**
     * @return \Articles\Blog
     */
    function method1()
    {
    }
}
\class_alias('Phpactor202301\\ParentClass', 'ParentClass', \false);
class Foobar extends ParentClass
{
    /**
     * {@inheritdoc}
     */
    function method1()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function (ReflectionMethodCollection $methods) : void {
            $this->assertEquals('Phpactor202301\\Articles\\Blog', $methods->get('method1')->inferredType()->__toString());
        }]);
        (yield 'Return type from inherited docblock (from interface)' => [<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Acme\Post;
interface Barbar
{
    /**
     * @return \Articles\Blog
     */
    function method1();
}
\class_alias('Phpactor202301\\Barbar', 'Barbar', \false);
class Foobar implements Barbar
{
    /**
     * {@inheritdoc}
     */
    function method1()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function ($methods) : void {
            $this->assertEquals('Phpactor202301\\Articles\\Blog', $methods->get('method1')->inferredType()->__toString());
        }]);
        (yield 'It reflects an abstract method' => [<<<'EOT'
<?php

namespace Phpactor202301;

abstract class Foobar
{
    public abstract function method();
    public function methodNonAbstract();
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function ($methods) : void {
            $this->assertTrue($methods->get('method')->isAbstract());
            $this->assertFalse($methods->get('methodNonAbstract')->isAbstract());
        }]);
        (yield 'It returns the method parameters' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function barfoo($foobar, Barfoo $barfoo, int $number)
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function ($methods) : void {
            $this->assertCount(3, $methods->get('barfoo')->parameters());
        }]);
        (yield 'It returns the nullable parameter types' => [<<<'EOT'
<?php

namespace Phpactor202301\Test;

class Foobar
{
    public function barfoo(?Barfoo $barfoo)
    {
    }
}
EOT
, 'Phpactor202301\\Test\\Foobar', function ($methods) : void {
            $this->assertCount(1, $methods->get('barfoo')->parameters());
            $this->assertEquals('?Test\\Barfoo', $methods->get('barfoo')->parameters()->first()->type()->__toString());
        }]);
        (yield 'It tolerantes and logs method parameters with missing variables parameter' => [<<<'EOT'
<?php

class Foobar
{
    public function barfoo(Barfoo = null)
    {
    }
}
EOT
, 'Foobar', function ($methods, LoggerInterface $logger) : void {
            $this->assertEquals('', $methods->get('barfoo')->parameters()->first()->name());
            $this->assertStringContainsString('Parameter has no variable', $logger->messages()[2]);
        }]);
        (yield 'It returns the raw docblock' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * Hello this is a docblock.
     */
    public function barfoo($foobar, Barfoo $barfoo, int $number)
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function ($methods) : void {
            $this->assertStringContainsString(<<<EOT
Hello this is a docblock.
EOT
, $methods->get('barfoo')->docblock()->raw());
        }]);
        (yield 'It returns the formatted docblock' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    /**
     * Hello this is a docblock.
     *
     * Yes?
     */
    public function barfoo($foobar, Barfoo $barfoo, int $number)
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function ($methods) : void {
            $this->assertEquals(<<<EOT
Hello this is a docblock.

Yes?
EOT
, $methods->get('barfoo')->docblock()->formatted());
        }]);
        (yield 'It returns true if the method is static' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public static function barfoo($foobar, Barfoo $barfoo, int $number)
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function ($methods) : void {
            $this->assertTrue($methods->get('barfoo')->isStatic());
        }]);
        (yield 'It returns the method body' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
    public function barfoo()
    {
        echo "Hello!";
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function ($methods) : void {
            $this->assertEquals('echo "Hello!";', (string) $methods->get('barfoo')->body());
        }]);
        (yield 'It reflects a method from an inteface' => [<<<'EOT'
<?php

namespace Phpactor202301;

interface Foobar
{
    public function barfoo()
    {
        echo "Hello!";
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function ($methods) : void {
            $this->assertTrue($methods->has('barfoo'));
            $this->assertEquals('Foobar', (string) $methods->get('barfoo')->declaringClass()->name());
        }]);
        (yield 'It reflects a method from a trait' => [<<<'EOT'
<?php

namespace Phpactor202301;

trait Foobar
{
    public function barfoo()
    {
        echo "Hello!";
    }
}
EOT
, 'Foobar', function (ReflectionMethodCollection $methods) : void {
            $this->assertTrue($methods->has('barfoo'));
            $this->assertEquals('Foobar', (string) $methods->get('barfoo')->declaringClass()->name());
        }]);
        (yield 'It returns methods when a class extends itself' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar extends Foobar
{
    public function barfoo()
    {
        echo "Hello!";
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function (ReflectionMethodCollection $methods) : void {
            $this->assertTrue($methods->has('barfoo'));
        }]);
    }
    /**
     * Note that generics are now resolved during analysis and not statically.
     *
     * @return Generator<mixed>
     */
    public function provideGenerics() : Generator
    {
        (yield 'return type from generic' => [<<<'PHP'
<?php

namespace Phpactor202301;

/**
 * @template T
 */
abstract class Generic
{
    /**
     * @return T
     */
    public function bar()
    {
    }
}
/**
 * @template T
 */
\class_alias('Phpactor202301\\Generic', 'Generic', \false);
/**
 * @extends Generic<Baz>
 */
class Foobar extends Generic
{
}
/**
 * @extends Generic<Baz>
 */
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
PHP
, 'Foobar', function (ReflectionMethodCollection $methods) : void {
            self::assertTrue($methods->has('bar'));
            self::assertEquals('T', $methods->get('bar')->inferredType()->__toString());
        }]);
        (yield 'return type from generic with multiple parameters' => [<<<'PHP'
<?php

namespace Phpactor202301;

/**
 * @template T
 * @template V
 */
abstract class Generic
{
    /**
     * @return V
     */
    public function vee()
    {
    }
    /**
     * @return T
     */
    public function tee()
    {
    }
}
/**
 * @template T
 * @template V
 */
\class_alias('Phpactor202301\\Generic', 'Generic', \false);
/**
 * @extends Generic<Boo,Baz>
 */
class Foobar extends Generic
{
}
/**
 * @extends Generic<Boo,Baz>
 */
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
PHP
, 'Foobar', function (ReflectionMethodCollection $methods) : void {
            self::assertTrue($methods->has('tee'));
            self::assertTrue($methods->has('vee'));
            self::assertEquals('T', $methods->get('tee')->inferredType()->__toString());
            self::assertEquals('V', $methods->get('vee')->inferredType()->__toString());
        }]);
        (yield 'return type from generic with multiple parameters at a distance' => [<<<'PHP'
<?php

namespace Phpactor202301;

/**
 * @template T
 * @template V
 */
abstract class Generic
{
    /**
     * @return V
     */
    public function vee()
    {
    }
    /**
     * @return T
     */
    public function tee()
    {
    }
}
/**
 * @template T
 * @template V
 */
\class_alias('Phpactor202301\\Generic', 'Generic', \false);
/**
 * @template T
 * @template V
 * @template G
 * @extends Generic<T, V>
 */
abstract class Middle extends Generic
{
    /** @return G */
    public function gee()
    {
    }
}
/**
 * @template T
 * @template V
 * @template G
 * @extends Generic<T, V>
 */
\class_alias('Phpactor202301\\Middle', 'Middle', \false);
/**
 * @extends Middle<Boo,Baz,Bom>
 */
class Foobar extends Middle
{
}
/**
 * @extends Middle<Boo,Baz,Bom>
 */
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
PHP
, 'Foobar', function (ReflectionMethodCollection $methods) : void {
            self::assertTrue($methods->has('tee'));
            self::assertTrue($methods->has('vee'));
            self::assertTrue($methods->has('gee'));
            self::assertEquals('T', $methods->get('tee')->inferredType()->__toString());
            self::assertEquals('V', $methods->get('vee')->inferredType()->__toString());
            self::assertEquals('G', $methods->get('gee')->inferredType()->__toString());
        }]);
    }
    /**
     * @return Generator<mixed>
     */
    public function provideDeprecations() : Generator
    {
        (yield 'It shows when method is deprecated' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar extends Foobar
{
    /**
     * @deprecated Foobar this hello
     */
    public function barfoo()
    {
        echo "Hello!";
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function (ReflectionMethodCollection $methods) : void {
            $this->assertTrue($methods->has('barfoo'));
            $this->assertTrue($methods->get('barfoo')->deprecation()->isDefined());
        }]);
    }
    /**
     * @dataProvider provideReflectionMethodCollection
     */
    public function testReflectCollection(string $source, string $class, Closure $assertion) : void
    {
        $class = $this->createReflector($source)->reflectClassLike(ClassName::fromString($class));
        $assertion($class);
    }
    public function provideReflectionMethodCollection()
    {
        return ['Only methods belonging to a given class' => [<<<'EOT'
<?php

namespace Phpactor202301;

class ParentClass
{
    public function method1()
    {
    }
}
\class_alias('Phpactor202301\\ParentClass', 'ParentClass', \false);
class Foobar extends ParentClass
{
    public function method4()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
EOT
, 'Foobar', function (ReflectionClass $class) : void {
            $methods = $class->methods()->belongingTo($class->name());
            $this->assertEquals(['method4'], $methods->keys());
        }]];
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\TolerantParser\\Reflection\\ReflectionMethodTest', 'Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\TolerantParser\\Reflection\\ReflectionMethodTest', \false);
