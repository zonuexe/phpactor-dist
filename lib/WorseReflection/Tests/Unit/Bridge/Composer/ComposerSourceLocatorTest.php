<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Unit\Bridge\Composer;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Bridge\Composer\ComposerSourceLocator;
use Phpactor202301\Phpactor\WorseReflection\Core\Name;
class ComposerSourceLocatorTest extends TestCase
{
    public function testLocate() : void
    {
        $autoloader = (require __DIR__ . '/../../../../../../vendor/autoload.php');
        $locator = new ComposerSourceLocator($autoloader);
        $sourceCode = $locator->locate(Name::fromString(ComposerSourceLocatorTest::class));
        $this->assertEquals(__FILE__, \realpath($sourceCode->path()));
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Unit\\Bridge\\Composer\\ComposerSourceLocatorTest', 'Phpactor\\WorseReflection\\Tests\\Unit\\Bridge\\Composer\\ComposerSourceLocatorTest', \false);
