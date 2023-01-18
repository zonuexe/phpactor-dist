<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCompletion\Tests;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Container\PhpactorContainer;
use Phpactor202301\Phpactor\Extension\ClassToFile\ClassToFileExtension;
use Phpactor202301\Phpactor\Extension\CodeTransform\CodeTransformExtension;
use Phpactor202301\Phpactor\Extension\CompletionWorse\CompletionWorseExtension;
use Phpactor202301\Phpactor\Extension\Completion\CompletionExtension;
use Phpactor202301\Phpactor\Extension\ComposerAutoloader\ComposerAutoloaderExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\LanguageServerBridgeExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerCodeTransform\LanguageServerCodeTransformExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerCompletion\LanguageServerCompletionExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerCompletion\Tests\Extension\TestExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerHover\LanguageServerHoverExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerWorseReflection\LanguageServerWorseReflectionExtension;
use Phpactor202301\Phpactor\Extension\LanguageServer\LanguageServerExtension;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\ObjectRenderer\ObjectRendererExtension;
use Phpactor202301\Phpactor\Extension\Php\PhpExtension;
use Phpactor202301\Phpactor\Extension\ReferenceFinder\ReferenceFinderExtension;
use Phpactor202301\Phpactor\Extension\SourceCodeFilesystem\SourceCodeFilesystemExtension;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
use Phpactor202301\Phpactor\Indexer\Extension\IndexerExtension;
use Phpactor202301\Phpactor\LanguageServer\LanguageServerBuilder;
use Phpactor202301\Phpactor\LanguageServer\Test\LanguageServerTester;
use Phpactor202301\Phpactor\LanguageServer\Test\ProtocolFactory;
use Phpactor202301\Phpactor\TestUtils\Workspace;
class IntegrationTestCase extends TestCase
{
    protected function workspace() : Workspace
    {
        return Workspace::create(__DIR__ . '/Workspace');
    }
    protected function createTester() : LanguageServerTester
    {
        $container = PhpactorContainer::fromExtensions([LoggingExtension::class, CompletionExtension::class, LanguageServerExtension::class, LanguageServerCodeTransformExtension::class, LanguageServerCompletionExtension::class, FilePathResolverExtension::class, ClassToFileExtension::class, ComposerAutoloaderExtension::class, CodeTransformExtension::class, WorseReflectionExtension::class, CompletionWorseExtension::class, SourceCodeFilesystemExtension::class, LanguageServerWorseReflectionExtension::class, LanguageServerHoverExtension::class, PhpExtension::class, TestExtension::class, IndexerExtension::class, ReferenceFinderExtension::class, LanguageServerBridgeExtension::class, ObjectRendererExtension::class], [FilePathResolverExtension::PARAM_APPLICATION_ROOT => __DIR__ . '/../../../../', ObjectRendererExtension::PARAM_TEMPLATE_PATHS => [], IndexerExtension::PARAM_ENABLED_WATCHERS => []]);
        $builder = $container->get(LanguageServerBuilder::class);
        $this->assertInstanceOf(LanguageServerBuilder::class, $builder);
        return $builder->tester(ProtocolFactory::initializeParams($this->workspace()->path('/')));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCompletion\\Tests\\IntegrationTestCase', 'Phpactor\\Extension\\LanguageServerCompletion\\Tests\\IntegrationTestCase', \false);
