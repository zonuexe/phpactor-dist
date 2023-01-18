<?php

namespace Phpactor202301\Phpactor\Extension\Behat\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Container\PhpactorContainer;
use Phpactor202301\Phpactor\Extension\Behat\BehatExtension;
use Phpactor202301\Phpactor\Extension\ClassToFile\ClassToFileExtension;
use Phpactor202301\Phpactor\Extension\ComposerAutoloader\ComposerAutoloaderExtension;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\ReferenceFinder\ReferenceFinderExtension;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor202301\Phpactor\ReferenceFinder\DefinitionLocator;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
class BehatExtensionTest extends TestCase
{
    public function testStepDefinitionFinder() : void
    {
        $container = PhpactorContainer::fromExtensions([BehatExtension::class, ReferenceFinderExtension::class, FilePathResolverExtension::class, WorseReflectionExtension::class, ClassToFileExtension::class, ComposerAutoloaderExtension::class, LoggingExtension::class], [FilePathResolverExtension::PARAM_APPLICATION_ROOT => __DIR__ . '/../../../../..', BehatExtension::PARAM_CONFIG_PATH => __DIR__ . '/../Integration/Completor/behat.yml']);
        $locator = $container->get(ReferenceFinderExtension::SERVICE_DEFINITION_LOCATOR);
        \assert($locator instanceof DefinitionLocator);
        $location = $locator->locateDefinition(TextDocumentBuilder::fromUri(__DIR__ . '/../Integration/Completor/feature/some_feature.feature')->language('cucumber')->build(), ByteOffset::fromInt(69));
        $this->assertStringContainsString('ExampleContext.php', $location->first()->location()->uri()->path());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Behat\\Tests\\Unit\\BehatExtensionTest', 'Phpactor\\Extension\\Behat\\Tests\\Unit\\BehatExtensionTest', \false);
