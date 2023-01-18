<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Integration\Bridge\TolerantParser\Reflection;

use Phpactor202301\Phpactor\WorseReflection\Tests\Integration\IntegrationTestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMethodCall;
use Phpactor202301\Phpactor\WorseReflection\Core\Position;
use Phpactor202301\Phpactor\TestUtils\ExtractOffset;
use Closure;
class ReflectionMethodCallTest extends IntegrationTestCase
{
    /**
     * @dataProvider provideReflectionMethod
     */
    public function testReflectMethodCall(string $source, array $frame, Closure $assertion) : void
    {
        [$source, $offset] = ExtractOffset::fromSource($source);
        $reflection = $this->createReflector($source)->reflectMethodCall($source, $offset);
        $assertion($reflection);
    }
    public function provideReflectionMethod()
    {
        return ['It reflects the method name' => [<<<'EOT'
<?php

namespace Phpactor202301;

$foo->b != ar();
EOT
, [], function (ReflectionMethodCall $method) : void {
            $this->assertEquals('bar', $method->name());
        }], 'It reflects a method' => [<<<'EOT'
<?php

namespace Phpactor202301;

$foo->b != ar();
EOT
, [], function (ReflectionMethodCall $method) : void {
            $this->assertEquals('bar', $method->name());
        }], 'It returns the position' => [<<<'EOT'
<?php

namespace Phpactor202301;

$foo->foo->b != ar();
EOT
, [], function (ReflectionMethodCall $method) : void {
            $this->assertInstanceOf(Position::class, $method->position());
            $this->assertEquals(7, $method->position()->start());
            $this->assertEquals(21, $method->position()->end());
        }], 'It returns the containing class' => [<<<'EOT'
<?php

namespace Phpactor202301;

class BBB
{
}
\class_alias('Phpactor202301\\BBB', 'BBB', \false);
class AAA
{
    public function foo() : BBB
    {
    }
}
\class_alias('Phpactor202301\\AAA', 'AAA', \false);
$foo = new AAA();
$foo->foo()->b != ar();

EOT
, [], function (ReflectionMethodCall $method) : void {
            $this->assertInstanceOf(Position::class, $method->position());
            $this->assertEquals(ClassName::fromString('BBB'), $method->class()->name());
        }], 'It returns if the call is static' => [<<<'EOT'
<?php

namespace Phpactor202301;

class AAA
{
}
\class_alias('Phpactor202301\\AAA', 'AAA', \false);
AAA::b != ar();

EOT
, [], function (ReflectionMethodCall $method) : void {
            $this->assertInstanceOf(Position::class, $method->position());
            $this->assertTrue($method->isStatic());
            $this->assertEquals(ClassName::fromString('AAA'), $method->class()->name());
        }], 'It has arguments' => [<<<'EOT'
<?php

namespace Phpactor202301;

class AAA
{
}
\class_alias('Phpactor202301\\AAA', 'AAA', \false);
$a = 1;
$foo = new AAA();
$foo->b != ar($a);

EOT
, [], function (ReflectionMethodCall $method) : void {
            $this->assertInstanceOf(Position::class, $method->position());
            $this->assertEquals('a', $method->arguments()->first()->guessName());
        }]];
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\TolerantParser\\Reflection\\ReflectionMethodCallTest', 'Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\TolerantParser\\Reflection\\ReflectionMethodCallTest', \false);
