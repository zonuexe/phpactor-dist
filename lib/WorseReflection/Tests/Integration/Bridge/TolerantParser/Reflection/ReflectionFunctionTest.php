<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Integration\Bridge\TolerantParser\Reflection;

use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Tests\Integration\IntegrationTestCase;
use Closure;
use Phpactor202301\Phpactor\WorseReflection\Core\Position;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionFunction;
class ReflectionFunctionTest extends IntegrationTestCase
{
    /**
     * @dataProvider provideReflectsFunction
     */
    public function testReflects(string $source, string $functionName, Closure $assertion) : void
    {
        $functions = $this->createReflector($source)->reflectFunctionsIn($source);
        $assertion($functions->get($functionName));
    }
    public function provideReflectsFunction()
    {
        (yield 'single function with no params' => [<<<'EOT'
<?php

namespace Phpactor202301;

function hello()
{
}
EOT
, 'hello', function (ReflectionFunction $function) : void {
            $this->assertEquals('hello', $function->name());
            $this->assertEquals(Position::fromStartAndEnd(6, 26), $function->position());
        }]);
        (yield 'function\'s frame' => [<<<'EOT'
<?php

namespace Phpactor202301;

function hello()
{
    $hello = 'hello';
}
EOT
, 'hello', function (ReflectionFunction $function) : void {
            $this->assertCount(1, $function->frame()->locals());
        }]);
        (yield 'the docblock' => [<<<'EOT'
<?php

namespace Phpactor202301;

/** Hello */
function hello()
{
    $hello = 'hello';
}
EOT
, 'hello', function (ReflectionFunction $function) : void {
            $this->assertEquals('/** Hello */', \trim($function->docblock()->raw()));
        }]);
        (yield 'the declared scalar type' => [<<<'EOT'
<?php

namespace Phpactor202301;

function hello() : string
{
}
EOT
, 'hello', function (ReflectionFunction $function) : void {
            $this->assertEquals('string', $function->type());
        }]);
        (yield 'the declared class type' => [<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Foobar\Barfoo;
function hello() : Barfoo
{
}
EOT
, 'hello', function (ReflectionFunction $function) : void {
            $this->assertEquals('Phpactor202301\\Foobar\\Barfoo', $function->type());
        }]);
        (yield 'the declared union type' => [<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\Foobar\Barfoo;
function hello() : string|Barfoo
{
}
EOT
, 'hello', function (ReflectionFunction $function) : void {
            $this->assertEquals('string|Foobar\\Barfoo', $function->type()->__toString());
        }]);
        (yield 'unknown if nothing declared as type' => [<<<'EOT'
<?php

namespace Phpactor202301;

function hello()
{
}
EOT
, 'hello', function (ReflectionFunction $function) : void {
            $this->assertEquals(TypeFactory::unknown(), $function->type());
        }]);
        (yield 'type from docblock' => [<<<'EOT'
<?php

namespace Phpactor202301;

/**
 * @return string
 */
function hello()
{
}
EOT
, 'hello', function (ReflectionFunction $function) : void {
            $this->assertEquals(TypeFactory::string(), $function->inferredType());
        }]);
        (yield 'resolved type class from docblock' => [<<<'EOT'
<?php

namespace Phpactor202301\Bar;

use Phpactor202301\Foo\Goodbye;
/**
 * @return Goodbye
 */
function hello()
{
}
EOT
, 'Phpactor202301\\Bar\\hello', function (ReflectionFunction $function) : void {
            $this->assertEquals('Phpactor202301\\Foo\\Goodbye', $function->inferredType()->__toString());
        }]);
        (yield 'parameters' => [<<<'EOT'
<?php

namespace Phpactor202301\Bar;

function hello($foobar, Barfoo $barfoo, int $number)
{
}
EOT
, 'Phpactor202301\\Bar\\hello', function (ReflectionFunction $function) : void {
            $this->assertCount(3, $function->parameters());
            $this->assertEquals('Phpactor202301\\Bar\\Barfoo', $function->parameters()->get('barfoo')->inferredType());
        }]);
        (yield 'returns the source code' => [<<<'EOT'
<?php

namespace Phpactor202301\Bar;

function hello($foobar, Barfoo $barfoo, int $number)
{
}
EOT
, 'Phpactor202301\\Bar\\hello', function (ReflectionFunction $function) : void {
            $this->assertStringContainsString('function hello(', (string) $function->sourceCode());
        }]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\TolerantParser\\Reflection\\ReflectionFunctionTest', 'Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\TolerantParser\\Reflection\\ReflectionFunctionTest', \false);
