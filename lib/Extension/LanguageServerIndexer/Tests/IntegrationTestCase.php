<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerIndexer\Tests;

use Phpactor202301\Phpactor\Extension\LanguageServerBridge\LanguageServerBridgeExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerIndexer\LanguageServerIndexerExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerIndexer\Tests\Extension\TestExtension;
use Phpactor202301\Phpactor\Extension\LanguageServer\LanguageServerExtension;
use Phpactor202301\Phpactor\Extension\ReferenceFinder\ReferenceFinderExtension;
use Phpactor202301\Phpactor\Extension\ComposerAutoloader\ComposerAutoloaderExtension;
use Phpactor202301\Phpactor\Extension\ClassToFile\ClassToFileExtension;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor202301\Phpactor\Extension\SourceCodeFilesystem\SourceCodeFilesystemExtension;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
use Phpactor202301\Phpactor\Extension\Console\ConsoleExtension;
use Phpactor202301\Phpactor\Container\PhpactorContainer;
use Phpactor202301\Phpactor\Indexer\Extension\IndexerExtension;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\TestUtils\PHPUnit\TestCase;
use Phpactor202301\Phpactor\TestUtils\Workspace;
class IntegrationTestCase extends TestCase
{
    protected function workspace() : Workspace
    {
        return Workspace::create(__DIR__ . '/Workspace');
    }
    protected function container(array $config = []) : Container
    {
        $container = PhpactorContainer::fromExtensions([ConsoleExtension::class, IndexerExtension::class, FilePathResolverExtension::class, LoggingExtension::class, SourceCodeFilesystemExtension::class, WorseReflectionExtension::class, ClassToFileExtension::class, ComposerAutoloaderExtension::class, ReferenceFinderExtension::class, LanguageServerIndexerExtension::class, LanguageServerExtension::class, LanguageServerBridgeExtension::class, TestExtension::class], \array_merge([FilePathResolverExtension::PARAM_APPLICATION_ROOT => __DIR__ . '/../', FilePathResolverExtension::PARAM_PROJECT_ROOT => $this->workspace()->path(), IndexerExtension::PARAM_INDEX_PATH => $this->workspace()->path('/cache'), LoggingExtension::PARAM_ENABLED => \false, LoggingExtension::PARAM_PATH => 'php://stderr', WorseReflectionExtension::PARAM_ENABLE_CACHE => \false, IndexerExtension::PARAM_ENABLED_WATCHERS => []], $config));
        return $container;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerIndexer\\Tests\\IntegrationTestCase', 'Phpactor\\Extension\\LanguageServerIndexer\\Tests\\IntegrationTestCase', \false);
