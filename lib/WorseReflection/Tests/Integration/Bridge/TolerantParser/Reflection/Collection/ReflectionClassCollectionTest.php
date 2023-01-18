<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Integration\Bridge\TolerantParser\Reflection\Collection;

use Phpactor202301\Phpactor\WorseReflection\Tests\Integration\IntegrationTestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionClassLikeCollection;
use Closure;
class ReflectionClassCollectionTest extends IntegrationTestCase
{
    /**
     * @dataProvider provideCollection
     */
    public function testCollection(string $source, Closure $assertion) : void
    {
        $collection = $this->createReflector($source)->reflectClassesIn($source);
        $assertion($collection);
    }
    public function provideCollection()
    {
        return ['It has all the classes' => [<<<'EOT'
<?php

namespace Phpactor202301;

class Foobar
{
}
\class_alias('Phpactor202301\\Foobar', 'Foobar', \false);
class Barfoo
{
}
\class_alias('Phpactor202301\\Barfoo', 'Barfoo', \false);
EOT
, function (ReflectionClassLikeCollection $collection) : void {
            $this->assertEquals(2, $collection->count());
        }], 'It reflects nested classes' => [<<<'EOT'
<?php

namespace Phpactor202301;

if (\true) {
    class Foobar
    {
    }
}
EOT
, function (ReflectionClassLikeCollection $collection) : void {
            $this->assertEquals(1, $collection->count());
        }]];
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\TolerantParser\\Reflection\\Collection\\ReflectionClassCollectionTest', 'Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\TolerantParser\\Reflection\\Collection\\ReflectionClassCollectionTest', \false);
