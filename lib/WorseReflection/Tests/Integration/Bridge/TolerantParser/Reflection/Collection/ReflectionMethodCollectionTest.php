<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Integration\Bridge\TolerantParser\Reflection\Collection;

use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClass;
use Phpactor202301\Phpactor\WorseReflection\Tests\Integration\IntegrationTestCase;
use Closure;
class ReflectionMethodCollectionTest extends IntegrationTestCase
{
    /**
     * @dataProvider provideCollection
     */
    public function testCollection(string $source, Closure $assertion) : void
    {
        $collection = $this->createReflector($source)->reflectClass('Foobar');
        $assertion($collection);
    }
    public function provideCollection()
    {
        (yield 'Get abstract methods' => [<<<'EOT'
<?php

namespace Phpactor202301;

abstract class Foobar
{
    public function one()
    {
    }
    abstract function two()
    {
    }
    abstract function three()
    {
    }
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);

EOT
, function (ReflectionClass $class) : void {
            $this->assertEquals(2, $class->methods()->abstract()->count());
        }]);
        (yield 'Get abstract methods with virtual methods' => [<<<'EOT'
<?php

namespace Phpactor202301;

/**
* @method Barfoo barfoo()
*/
abstract class Foobar
{
    public function one()
    {
    }
    abstract function two()
    {
    }
    abstract function three()
    {
    }
}
/**
* @method Barfoo barfoo()
*/
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);

EOT
, function (ReflectionClass $class) : void {
            $this->assertEquals(2, $class->methods()->abstract()->count());
        }]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\TolerantParser\\Reflection\\Collection\\ReflectionMethodCollectionTest', 'Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\TolerantParser\\Reflection\\Collection\\ReflectionMethodCollectionTest', \false);
