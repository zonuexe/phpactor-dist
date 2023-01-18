<?php

namespace Phpactor202301\Phpactor\Extension\ComposerAutoloader\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\PhpactorContainer;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\ComposerAutoloader\ComposerAutoloaderExtension;
use Phpactor202301\Composer\Autoload\ClassLoader;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
class ComposerAutoloaderExtensionTest extends TestCase
{
    public function testProvidesAutoloaders() : void
    {
        $autoloaders = $this->create([])->get(ComposerAutoloaderExtension::SERVICE_AUTOLOADERS);
        $this->assertCount(1, $autoloaders);
        $autoloader = \reset($autoloaders);
        $this->assertInstanceOf(ClassLoader::class, $autoloader);
    }
    public function testProvidesAutoloadersNoDeregister() : void
    {
        $autoloaders = $this->create([ComposerAutoloaderExtension::PARAM_AUTOLOAD_DEREGISTER => \false])->get(ComposerAutoloaderExtension::SERVICE_AUTOLOADERS);
        $this->assertCount(1, $autoloaders);
        $autoloader = \reset($autoloaders);
        $this->assertInstanceOf(ClassLoader::class, $autoloader);
    }
    public function testWithCustomProjectRoot() : void
    {
        $autoloaders = $this->create([])->get(ComposerAutoloaderExtension::SERVICE_AUTOLOADERS);
        $this->assertCount(1, $autoloaders);
        $autoloader = \reset($autoloaders);
        $this->assertInstanceOf(ClassLoader::class, $autoloader);
    }
    public function testWarningForNonExistingLoader() : void
    {
        $autoloaders = $this->create([ComposerAutoloaderExtension::PARAM_AUTOLOADER_PATH => 'not-existing.php'])->get(ComposerAutoloaderExtension::SERVICE_AUTOLOADERS);
        $this->assertCount(0, $autoloaders);
    }
    public function testWarningAutoloaderIsntAutoloader() : void
    {
        $autoloaders = $this->create([ComposerAutoloaderExtension::PARAM_AUTOLOADER_PATH => __DIR__ . '/not-an-autoloader.php'])->get(ComposerAutoloaderExtension::SERVICE_AUTOLOADERS);
        $this->assertCount(1, $autoloaders);
    }
    public function testMultipleAutoloaders() : void
    {
        $autoloaders = $this->create([ComposerAutoloaderExtension::PARAM_AUTOLOADER_PATH => [__DIR__ . '/../../../../../vendor/autoload.php', __DIR__ . '/../../../../../vendor/autoload.php']])->get(ComposerAutoloaderExtension::SERVICE_AUTOLOADERS);
        $this->assertCount(2, $autoloaders);
    }
    private function create(array $config) : Container
    {
        return PhpactorContainer::fromExtensions([ComposerAutoloaderExtension::class, LoggingExtension::class, FilePathResolverExtension::class], $config);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\ComposerAutoloader\\Tests\\Unit\\ComposerAutoloaderExtensionTest', 'Phpactor\\Extension\\ComposerAutoloader\\Tests\\Unit\\ComposerAutoloaderExtensionTest', \false);
