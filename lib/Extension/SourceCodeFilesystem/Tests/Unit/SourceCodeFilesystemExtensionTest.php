<?php

namespace Phpactor202301\Phpactor\Extension\SourceCodeFilesystem\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Container\PhpactorContainer;
use Phpactor202301\Phpactor\Extension\ComposerAutoloader\ComposerAutoloaderExtension;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\SourceCodeFilesystem\SourceCodeFilesystemExtension;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
use Phpactor202301\Phpactor\Filesystem\Adapter\Git\GitFilesystem;
use Phpactor202301\Phpactor\Filesystem\Adapter\Simple\SimpleFilesystem;
use Phpactor202301\Phpactor\Filesystem\Domain\FilesystemRegistry;
class SourceCodeFilesystemExtensionTest extends TestCase
{
    /**
     * @dataProvider provideFilesystems
     */
    public function testFilesystems(string $filesystem, string $expectedClass) : void
    {
        $registry = $this->createRegistry([ComposerAutoloaderExtension::PARAM_AUTOLOADER_PATH => __DIR__ . '/../../vendor/autoload.php']);
        $this->assertInstanceOf($expectedClass, $registry->get($filesystem));
    }
    public function provideFilesystems()
    {
        // disable this as travis does not have git when tested via. the
        // Phpactor test suite (this is there installed as a dependency).
        // yield [ 'git', GitFilesystem::class ];
        (yield ['simple', SimpleFilesystem::class]);
        (yield ['composer', SimpleFilesystem::class]);
    }
    public function testComposerNotSupported() : void
    {
        $registry = $this->createRegistry([SourceCodeFilesystemExtension::PARAM_PROJECT_ROOT => __DIR__, ComposerAutoloaderExtension::PARAM_AUTOLOADER_PATH => __DIR__ . '/no-autoload.php']);
        $composer = $registry->get('composer');
        $this->assertInstanceOf(SimpleFilesystem::class, $composer);
    }
    public function createRegistry(array $config) : FilesystemRegistry
    {
        $container = PhpactorContainer::fromExtensions([SourceCodeFilesystemExtension::class, ComposerAutoloaderExtension::class, LoggingExtension::class, FilePathResolverExtension::class], $config);
        return $container->get(SourceCodeFilesystemExtension::SERVICE_REGISTRY);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\SourceCodeFilesystem\\Tests\\Unit\\SourceCodeFilesystemExtensionTest', 'Phpactor\\Extension\\SourceCodeFilesystem\\Tests\\Unit\\SourceCodeFilesystemExtensionTest', \false);
