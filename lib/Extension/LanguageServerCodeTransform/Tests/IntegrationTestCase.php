<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\Tests;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\PhpactorContainer;
use Phpactor202301\Phpactor\Extension\ClassToFile\ClassToFileExtension;
use Phpactor202301\Phpactor\Extension\CodeTransform\CodeTransformExtension;
use Phpactor202301\Phpactor\Extension\ComposerAutoloader\ComposerAutoloaderExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\LanguageServerBridgeExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LanguageServerCodeTransformExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerIndexer\LanguageServerIndexerExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerWorseReflection\LanguageServerWorseReflectionExtension;
use Phpactor202301\Phpactor\Extension\LanguageServer\LanguageServerExtension;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\Php\PhpExtension;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
use Phpactor202301\Phpactor\Indexer\Extension\IndexerExtension;
use Phpactor202301\Phpactor\TestUtils\Workspace;
class IntegrationTestCase extends TestCase
{
    public function container(array $config = []) : Container
    {
        $this->workspace()->put('index/.foo', '');
        $container = PhpactorContainer::fromExtensions([LoggingExtension::class, LanguageServerExtension::class, FilePathResolverExtension::class, ClassToFileExtension::class, ComposerAutoloaderExtension::class, CodeTransformExtension::class, LanguageServerCodeTransformExtension::class, WorseReflectionExtension::class, IndexerExtension::class, LanguageServerIndexerExtension::class, LanguageServerWorseReflectionExtension::class, PhpExtension::class, LanguageServerBridgeExtension::class, TestLanguageServerSessionExtension::class], \array_merge([FilePathResolverExtension::PARAM_APPLICATION_ROOT => __DIR__ . '/../../', WorseReflectionExtension::PARAM_STUB_DIR => __DIR__ . '/Empty', WorseReflectionExtension::PARAM_STUB_CACHE_DIR => __DIR__ . '/Workspace/wr-cache', IndexerExtension::PARAM_STUB_PATHS => [__DIR__ . '/Stub'], CodeTransformExtension::PARAM_TEMPLATE_PATHS => [], FilePathResolverExtension::PARAM_PROJECT_ROOT => $this->workspace()->path(), IndexerExtension::PARAM_INDEX_PATH => $this->workspace()->path('index'), LoggingExtension::PARAM_ENABLED => \true, IndexerExtension::PARAM_ENABLED_WATCHERS => [], LanguageServerExtension::PARAM_DIAGNOSTIC_SLEEP_TIME => 0], $config));
        return $container;
    }
    protected function workspace() : Workspace
    {
        return Workspace::create(__DIR__ . '/Workspace');
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\IntegrationTestCase', 'Phpactor\\Extension\\LanguageServerCodeTransform\\Tests\\IntegrationTestCase', \false);
