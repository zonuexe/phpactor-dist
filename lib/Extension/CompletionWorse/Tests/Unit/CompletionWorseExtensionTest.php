<?php

namespace Phpactor202301\Phpactor\Extension\CompletionWorse\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Completion\Core\Completor;
use Phpactor202301\Phpactor\Completion\Core\DocumentPrioritizer\DocumentPrioritizer;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\PhpactorContainer;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\ClassToFile\ClassToFileExtension;
use Phpactor202301\Phpactor\Extension\CompletionWorse\CompletionWorseExtension;
use Phpactor202301\Phpactor\Extension\Completion\CompletionExtension;
use Phpactor202301\Phpactor\Extension\ComposerAutoloader\ComposerAutoloaderExtension;
use Phpactor202301\Phpactor\Extension\ObjectRenderer\ObjectRendererExtension;
use Phpactor202301\Phpactor\Extension\Php\PhpExtension;
use Phpactor202301\Phpactor\Extension\ReferenceFinder\ReferenceFinderExtension;
use Phpactor202301\Phpactor\Extension\SourceCodeFilesystem\SourceCodeFilesystemExtension;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
use RuntimeException;
class CompletionWorseExtensionTest extends TestCase
{
    public function testBuild() : void
    {
        $container = $this->buildContainer();
        $completor = $container->get(CompletionExtension::SERVICE_REGISTRY)->completorForType('php');
        $this->assertInstanceOf(Completor::class, $completor);
        \assert($completor instanceof Completor);
        $completor->complete(TextDocumentBuilder::create('<?php array')->build(), ByteOffset::fromInt(8));
    }
    public function testDisableCompletors() : void
    {
        $container = $this->buildContainer(['completion_worse.completor.worse_parameter.enabled' => \false]);
        $completors = $container->get('completion_worse.completor_map');
        self::assertFalse(\in_array('completion_worse.completor.constructor', $completors), 'Completor disabled');
    }
    public function testExceptionWhenSelectingUnknownSearchPriotityStrategy() : void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unknown search priority strategy "asd"');
        $container = $this->buildContainer([CompletionWorseExtension::PARAM_NAME_COMPLETION_PRIORITY => 'asd']);
        $container->get(DocumentPrioritizer::class);
    }
    /**
     * @param array<string,mixed> $config
     */
    private function buildContainer(array $config = []) : Container
    {
        return PhpactorContainer::fromExtensions([CompletionExtension::class, FilePathResolverExtension::class, ClassToFileExtension::class, ComposerAutoloaderExtension::class, LoggingExtension::class, WorseReflectionExtension::class, CompletionWorseExtension::class, SourceCodeFilesystemExtension::class, ReferenceFinderExtension::class, ObjectRendererExtension::class, PhpExtension::class], \array_merge([FilePathResolverExtension::PARAM_APPLICATION_ROOT => __DIR__, ObjectRendererExtension::PARAM_TEMPLATE_PATHS => []], $config));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\CompletionWorse\\Tests\\Unit\\CompletionWorseExtensionTest', 'Phpactor\\Extension\\CompletionWorse\\Tests\\Unit\\CompletionWorseExtensionTest', \false);
