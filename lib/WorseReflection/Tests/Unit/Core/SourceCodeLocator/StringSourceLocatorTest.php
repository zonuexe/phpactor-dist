<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Core\SourceCodeLocator;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator\StringSourceLocator;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode;
class StringSourceLocatorTest extends TestCase
{
    public function testLocate() : void
    {
        $locator = new StringSourceLocator(SourceCode::fromString('Hello'));
        $source = $locator->locate(ClassName::fromString('Foobar'));
        $this->assertEquals('Hello', (string) $source);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Core\\SourceCodeLocator\\StringSourceLocatorTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Core\\SourceCodeLocator\\StringSourceLocatorTest', \false);
