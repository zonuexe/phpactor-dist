<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Integration\Core;

use Closure;
use Generator;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\FunctionNotFound;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionFunction;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator\StubSourceLocator;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
use Phpactor202301\Phpactor\WorseReflection\Tests\Integration\IntegrationTestCase;
class FunctionReflectorTest extends IntegrationTestCase
{
    /**
     * @dataProvider provideReflectFunction
     */
    public function testReflectFunction(string $manifest, string $name, Closure $assertion) : void
    {
        $this->workspace()->reset();
        $this->workspace()->loadManifest($manifest);
        $locator = new StubSourceLocator(ReflectorBuilder::create()->build(), $this->workspace()->path('project'), $this->workspace()->path('cache'));
        $reflection = ReflectorBuilder::create()->addLocator($locator)->build()->reflectFunction($name);
        $assertion($reflection);
    }
    /**
     * @return Generator<mixed>
     */
    public function provideReflectFunction() : Generator
    {
        (yield 'reflect function' => [<<<'EOT'
// File: project/hello.php
<?php function hello() {}
EOT
, 'hello', function (ReflectionFunction $function) : void {
            $this->assertEquals('hello', $function->name());
        }]);
        (yield 'fallback to global function' => [<<<'EOT'
// File: project/global.php
<?php
function hello() {}
EOT
, 'Phpactor202301\\Foo\\hello', function (ReflectionFunction $function) : void {
            $this->assertEquals('hello', $function->name());
        }]);
        (yield 'namespaced function' => [<<<'EOT'
// File: project/global.php
<?php
namespace Foo;
function hello() {}
EOT
, 'Phpactor202301\\Foo\\hello', function (ReflectionFunction $function) : void {
            $this->assertEquals('Phpactor202301\\Foo\\hello', $function->name());
        }]);
    }
    public function testThrowsExceptionIfFunctionNotFound() : void
    {
        $this->expectException(FunctionNotFound::class);
        $this->createReflector('<?php ')->reflectFunction('hallo');
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Integration\\Core\\FunctionReflectorTest', 'Phpactor\\WorseReflection\\Tests\\Integration\\Core\\FunctionReflectorTest', \false);
