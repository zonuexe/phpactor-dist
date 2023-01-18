<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core\SourceCodeLocator;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\SourceNotFound;
use Phpactor202301\Phpactor\WorseReflection\Core\Name;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator\NativeReflectionFunctionSourceLocator;
class NativeReflectionFunctionSourceLocatorTest extends TestCase
{
    /**
     * @var ReflectionFunctionSourceLocator
     */
    private NativeReflectionFunctionSourceLocator $locator;
    public function setUp() : void
    {
        $this->locator = new NativeReflectionFunctionSourceLocator();
    }
    public function testLocatesAFunction() : void
    {
        $location = $this->locator->locate(Name::fromString(__NAMESPACE__ . '\\test_function'));
        $this->assertEquals(__FILE__, $location->path());
        $this->assertEquals(\file_get_contents(__FILE__), $location->__toString());
    }
    public function testThrowsExceptionWhenSourceNotFound() : void
    {
        $this->expectException(SourceNotFound::class);
        $this->locator->locate(Name::fromString(__NAMESPACE__ . '\\not_existing'));
    }
    public function testDoesNotLocateInternalFunctions() : void
    {
        $this->expectException(SourceNotFound::class);
        $this->locator->locate(Name::fromString('assert'));
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\SourceCodeLocator\\NativeReflectionFunctionSourceLocatorTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\SourceCodeLocator\\NativeReflectionFunctionSourceLocatorTest', \false);
function test_function() : void
{
}