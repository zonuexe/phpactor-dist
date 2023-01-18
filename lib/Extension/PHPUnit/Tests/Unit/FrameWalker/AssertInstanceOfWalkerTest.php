<?php

namespace Phpactor202301\Phpactor\Extension\PHPUnit\Tests\Unit\FrameWalker;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\PHPUnit\FrameWalker\AssertInstanceOfWalker;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Walker\TestAssertWalker;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
class AssertInstanceOfWalkerTest extends TestCase
{
    public function testStaticAssertCallWithClassConstant() : void
    {
        $this->resolve(<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\PHPUnit\Framework\Assert;
$foo;
Assert::assertInstanceOf(\stdClass::class, $foo);
wrAssertType('stdClass', $foo);
EOT
);
    }
    public function testStaticAssertCallWithClassString() : void
    {
        $this->resolve(<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\PHPUnit\Framework\Assert;
$foo;
Assert::assertInstanceOf('Phpactor202301\\foo\\bar', $foo);
wrAssertType('Phpactor202301\\foo\\bar', $foo);
EOT
);
    }
    public function testStaticAssertCallWithClassStringOnPreviouslyTypedVar() : void
    {
        $this->resolve(<<<'EOT'
<?php

use PHPUnit\Framework\Assert;
use Foo\Bar;

function (Node $foo) {
    Assert::assertInstanceOf(Bar::class, $foo);
    wrAssertType('Foo\Bar', $foo);
}
EOT
);
    }
    public function testInfersReflectedClass() : void
    {
        $this->resolve(<<<'EOT'
<?php

use PHPUnit\Framework\Assert;

class Bar { public function bar(): string {} }

function (Node $foo) {
    Assert::assertInstanceOf(Bar::class, $foo);
    wrAssertType('string', $foo->bar());
}
EOT
);
    }
    public function testInstanceCall() : void
    {
        $this->resolve(<<<'EOT'
<?php

namespace Phpactor202301;

use Phpactor202301\PHPUnit\Framework\Assert;
$foo;
Assert::assertInstanceOf("stdClass", $foo);
wrAssertType('stdClass', $foo);
EOT
);
    }
    public function resolve(string $sourceCode) : void
    {
        $reflector = ReflectorBuilder::create()->addFrameWalker(new TestAssertWalker($this))->addFrameWalker(new AssertInstanceOfWalker())->addSource($sourceCode)->build();
        $reflector->reflectOffset($sourceCode, \mb_strlen($sourceCode));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\PHPUnit\\Tests\\Unit\\FrameWalker\\AssertInstanceOfWalkerTest', 'Phpactor\\Extension\\PHPUnit\\Tests\\Unit\\FrameWalker\\AssertInstanceOfWalkerTest', \false);
