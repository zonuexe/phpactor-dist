<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Integration\Bridge\TolerantParser\Reflection;

use Phpactor202301\Phpactor\WorseReflection\Tests\Integration\IntegrationTestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionArgumentCollection;
use Phpactor202301\Phpactor\TestUtils\ExtractOffset;
use Closure;
class ReflectionArgumentTest extends IntegrationTestCase
{
    /**
     * @dataProvider provideReflectionMethod
     */
    public function testReflectMethodCall(string $source, array $frame, Closure $assertion) : void
    {
        [$source, $offset] = ExtractOffset::fromSource($source);
        $reflection = self::createReflector($source)->reflectMethodCall($source, $offset);
        $assertion($reflection->arguments());
    }
    public function provideReflectionMethod()
    {
        return ['It guesses the name from the var name' => [<<<'EOT'
<?php

namespace Phpactor202301;

$foo->b != ar($foo);
EOT
, [], function (ReflectionArgumentCollection $arguments) : void {
            self::assertEquals('foo', $arguments->first()->guessName());
        }], 'It guesses the name from return type' => [<<<'EOT'
<?php

namespace Phpactor202301;

class AAA
{
    public function bob() : Alice
    {
    }
}
\class_alias('Phpactor202301\\AAA', 'AAA', \false);
$foo = new AAA();
$foo->b != ar($foo->bob());
EOT
, [], function (ReflectionArgumentCollection $arguments) : void {
            self::assertEquals('alice', $arguments->first()->guessName());
        }], 'It returns a generated name if it cannot be determined' => [<<<'EOT'
<?php

namespace Phpactor202301;

class AAA
{
}
\class_alias('Phpactor202301\\AAA', 'AAA', \false);
$foo = new AAA();
$foo->b != ar($foo->bob(), $foo->zed());
EOT
, [], function (ReflectionArgumentCollection $arguments) : void {
            self::assertEquals('argument0', $arguments->first()->guessName());
            self::assertEquals('argument1', $arguments->last()->guessName());
        }], 'It returns the argument type' => [<<<'EOT'
<?php

namespace Phpactor202301;

$integer = 1;
$foo->b != ar($integer);
EOT
, [], function (ReflectionArgumentCollection $arguments) : void {
            self::assertEquals('1', (string) $arguments->first()->type());
        }], 'It returns the value' => [<<<'EOT'
<?php

namespace Phpactor202301;

$integer = 1;
$foo->b != ar($integer);
EOT
, [], function (ReflectionArgumentCollection $arguments) : void {
            self::assertEquals(1, $arguments->first()->value());
        }], 'It returns the position' => [<<<'EOT'
<?php

namespace Phpactor202301;

$foo->b != ar($integer);
EOT
, [], function (ReflectionArgumentCollection $arguments) : void {
            self::assertEquals(17, $arguments->first()->position()->start());
            self::assertEquals(25, $arguments->first()->position()->end());
        }]];
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\TolerantParser\\Reflection\\ReflectionArgumentTest', 'Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\TolerantParser\\Reflection\\ReflectionArgumentTest', \false);