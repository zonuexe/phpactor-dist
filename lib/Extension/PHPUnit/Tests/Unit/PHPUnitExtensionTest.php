<?php

namespace Phpactor202301\Phpactor\Extension\PHPUnit\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Container\PhpactorContainer;
use Phpactor202301\Phpactor\Extension\ClassToFile\ClassToFileExtension;
use Phpactor202301\Phpactor\Extension\ComposerAutoloader\ComposerAutoloaderExtension;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\PHPUnit\PHPUnitExtension;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
class PHPUnitExtensionTest extends TestCase
{
    public function testLoad() : void
    {
        $container = PhpactorContainer::fromExtensions([WorseReflectionExtension::class, PHPUnitExtension::class, FilePathResolverExtension::class, ClassToFileExtension::class, ComposerAutoloaderExtension::class, LoggingExtension::class], [FilePathResolverExtension::PARAM_APPLICATION_ROOT => __DIR__]);
        $reflector = $container->get(WorseReflectionExtension::SERVICE_REFLECTOR);
        $this->assertInstanceOf(Reflector::class, $reflector);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\PHPUnit\\Tests\\Unit\\PHPUnitExtensionTest', 'Phpactor\\Extension\\PHPUnit\\Tests\\Unit\\PHPUnitExtensionTest', \false);
