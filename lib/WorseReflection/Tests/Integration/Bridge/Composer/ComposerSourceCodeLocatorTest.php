<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Integration\Bridge\Composer;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\WorseReflection\Bridge\Composer\ComposerSourceLocator;
use Phpactor202301\Phpactor\WorseReflection\Core\Name;
class ComposerSourceCodeLocatorTest extends TestCase
{
    public function testLocateSource() : void
    {
        $classLoader = (require __DIR__ . '/../../../../../../vendor/autoload.php');
        $locator = new ComposerSourceLocator($classLoader);
        $code = $locator->locate(Name::fromString(__CLASS__));
        $this->assertSame(\file_get_contents(__FILE__), (string) $code);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\Composer\\ComposerSourceCodeLocatorTest', 'Phpactor\\WorseReflection\\Tests\\Integration\\Bridge\\Composer\\ComposerSourceCodeLocatorTest', \false);
