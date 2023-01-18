<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Integration\Bridge\TolerantParser\Reflection;

use Phpactor202301\Phpactor\WorseReflection\Tests\Integration\IntegrationTestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Phpactor\WorseReflection\Core\Name;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClass;
use Phpactor202301\Phpactor\WorseReflection\Core\NameImports;
use Closure;
class ReflectionScopeTest extends IntegrationTestCase
{
    /**
     * @dataProvider provideScope
     */
    public function testScope(string $source, string $class, Closure $assertion) : void
    {
        $class = $this->createReflector($source)->reflectClassLike(ClassName::fromString($class));
        $assertion($class);
    }
    public function provideScope()
    {
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
        (yield 'Returns local name' => [<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Foobar\Barfoo;
class Class2
{
}
\class_alias('Phpactor202301\\Class2', 'Class2', \false);

EOT
, 'Class2', function (ReflectionClass $class) : void {
            $this->assertEquals(Name::fromString('Barfoo'), $class->scope()->resolveLocalName(Name::fromString('Phpactor202301\\Foobar\\Barfoo')));
        }]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\TolerantParser\\Reflection\\ReflectionScopeTest', 'Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\TolerantParser\\Reflection\\ReflectionScopeTest', \false);
