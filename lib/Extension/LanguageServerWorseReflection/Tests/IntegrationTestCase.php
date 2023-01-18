<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerWorseReflection\Tests;

use Phpactor202301\Phpactor\Extension\LanguageServerWorseReflection\LanguageServerWorseReflectionExtension;
use Phpactor202301\Phpactor\Extension\LanguageServer\LanguageServerExtension;
use Phpactor202301\Phpactor\Extension\ComposerAutoloader\ComposerAutoloaderExtension;
use Phpactor202301\Phpactor\Extension\ClassToFile\ClassToFileExtension;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor202301\Phpactor\Extension\SourceCodeFilesystem\SourceCodeFilesystemExtension;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
use Phpactor202301\Phpactor\Extension\Console\ConsoleExtension;
use Phpactor202301\Phpactor\Container\PhpactorContainer;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\TestUtils\PHPUnit\TestCase;
use Phpactor202301\Phpactor\TestUtils\Workspace;
class IntegrationTestCase extends TestCase
{
    protected function workspace() : Workspace
    {
        return Workspace::create(__DIR__ . '/Workspace');
    }
    protected function container() : Container
    {
        $container = PhpactorContainer::fromExtensions([ConsoleExtension::class, FilePathResolverExtension::class, LoggingExtension::class, SourceCodeFilesystemExtension::class, WorseReflectionExtension::class, ClassToFileExtension::class, ComposerAutoloaderExtension::class, LanguageServerExtension::class, LanguageServerWorseReflectionExtension::class], [FilePathResolverExtension::PARAM_APPLICATION_ROOT => __DIR__ . '/../', FilePathResolverExtension::PARAM_PROJECT_ROOT => $this->workspace()->path(), WorseReflectionExtension::PARAM_ENABLE_CACHE => \false]);
        return $container;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerWorseReflection\\Tests\\IntegrationTestCase', 'Phpactor\\Extension\\LanguageServerWorseReflection\\Tests\\IntegrationTestCase', \false);
