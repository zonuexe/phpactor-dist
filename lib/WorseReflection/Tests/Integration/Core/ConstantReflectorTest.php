<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Integration\Core;

use Closure;
use Generator;
use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\ReflectionDeclaredConstant;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\ConstantNotFound;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator\StubSourceLocator;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
use Phpactor202301\Phpactor\WorseReflection\Tests\Integration\IntegrationTestCase;
class ConstantReflectorTest extends IntegrationTestCase
{
    /**
     * @dataProvider provideReflectDeclaredConstant
     */
    public function testReflectFunction(string $manifest, string $name, Closure $assertion) : void
    {
        $this->workspace()->reset();
        $this->workspace()->loadManifest($manifest);
        $locator = new StubSourceLocator(ReflectorBuilder::create()->build(), $this->workspace()->path('project'), $this->workspace()->path('cache'));
        $reflection = ReflectorBuilder::create()->addLocator($locator)->build()->reflectConstant($name);
        $assertion($reflection);
    }
    /**
     * @return Generator<mixed>
     */
    public function provideReflectDeclaredConstant() : Generator
    {
        (yield 'reflect in root namespace' => [<<<'EOT'
// File: project/hello.php
<?php define('HELLO', 'hello') {}
EOT
, 'HELLO', function (ReflectionDeclaredConstant $constant) : void {
            $this->assertEquals('"hello"', $constant->type()->__toString());
        }]);
        (yield 'fallback to global constant' => [<<<'EOT'
// File: project/global.php
<?php
<?php define('HELLO', 'hello') {}
EOT
, 'Phpactor202301\\Foo\\HELLO', function (ReflectionDeclaredConstant $constant) : void {
            $this->assertEquals('HELLO', $constant->name());
        }]);
        (yield 'namespaced function' => [<<<'EOT'
// File: project/global.php
<?php
<?php define('Foo\HELLO', 'hello') {}
EOT
, 'Phpactor202301\\Foo\\HELLO', function (ReflectionDeclaredConstant $function) : void {
            $this->assertEquals('Phpactor202301\\Foo\\HELLO', $function->name());
        }]);
    }
    public function testThrowsExceptionIfFunctionNotFound() : void
    {
        $this->expectException(ConstantNotFound::class);
        $this->createReflector('<?php ')->reflectConstant('hallo');
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Integration\\Core\\ConstantReflectorTest', 'Phpactor\\WorseReflection\\Tests\\Integration\\Core\\ConstantReflectorTest', \false);
