<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core\Reflector\SourceCode;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator\TemporarySourceLocator;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflector\SourceCode\ContextualSourceCodeReflector;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionOffset;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMethodCall;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
class ContextualSourceCodeReflectorTest extends TestCase
{
    use ProphecyTrait;
    const TEST_SOURCE_CODE = '<?php echo "hello";';
    const TEST_OFFSET = 1;
    private ContextualSourceCodeReflector $reflector;
    private $code;
    private TemporarySourceLocator $locator;
    public function setUp() : void
    {
        $this->locator = new TemporarySourceLocator(ReflectorBuilder::create()->build());
        $this->reflector = new ContextualSourceCodeReflector(ReflectorBuilder::create()->build(), $this->locator);
        $this->code = SourceCode::fromString(self::TEST_SOURCE_CODE);
    }
    public function testReflectsClassesIn() : void
    {
        self::assertEquals(2, $this->reflector->reflectClassesIn('<?php class One{} class Two{}')->count());
    }
    public function testReflectOffset() : void
    {
        $offset = $this->reflector->reflectOffset(self::TEST_SOURCE_CODE, self::TEST_OFFSET);
        self::assertInstanceOf(ReflectionOffset::class, $offset);
    }
    public function testReflectMethodCall() : void
    {
        $call = $this->reflector->reflectMethodCall('<?php class One { function bar() {} } $f = new One();$f->bar();', 59);
        self::assertInstanceOf(ReflectionMethodCall::class, $call);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Reflector\\SourceCode\\ContextualSourceCodeReflectorTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\Reflector\\SourceCode\\ContextualSourceCodeReflectorTest', \false);
