<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core\SourceCodeLocator;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator\TemporarySourceLocator;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\SourceNotFound;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
class TemporarySourceLocatorTest extends TestCase
{
    use ProphecyTrait;
    private TemporarySourceLocator $locator;
    private Reflector $reflector;
    public function setUp() : void
    {
        $this->locator = new TemporarySourceLocator(ReflectorBuilder::create()->build());
    }
    public function testThrowsExceptionWhenClassNotFound() : void
    {
        $this->expectException(SourceNotFound::class);
        $this->expectExceptionMessage('Class "Foobar" not found');
        $source = SourceCode::fromString('<?php class Boobar {}');
        $this->locator->pushSourceCode($source);
        $this->locator->locate(ClassName::fromString('Foobar'));
    }
    public function testReturnsSourceIfClassIsInTheSource() : void
    {
        $code = '<?php class Foobar {}';
        $this->locator->pushSourceCode(SourceCode::fromString($code));
        $source = $this->locator->locate(ClassName::fromString('Foobar'));
        $this->assertEquals($code, (string) $source);
    }
    public function testNewFilesOverridePreviousOnes() : void
    {
        $code1 = '<?php class Foobar {}';
        $this->locator->pushSourceCode(SourceCode::fromPathAndString('foo.php', $code1));
        $code2 = '<?php class Boobar {}';
        $this->locator->pushSourceCode(SourceCode::fromPathAndString('foo.php', $code2));
        $source = $this->locator->locate(ClassName::fromString('Boobar'));
        $this->assertEquals($code2, (string) $source);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\SourceCodeLocator\\TemporarySourceLocatorTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\SourceCodeLocator\\TemporarySourceLocatorTest', \false);
