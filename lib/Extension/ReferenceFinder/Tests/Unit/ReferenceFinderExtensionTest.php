<?php

namespace Phpactor202301\Phpactor\Extension\ReferenceFinder\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Container\PhpactorContainer;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\ReferenceFinder\ReferenceFinderExtension;
use Phpactor202301\Phpactor\Extension\ReferenceFinder\Tests\Example\SomeDefinitionLocator;
use Phpactor202301\Phpactor\Extension\ReferenceFinder\Tests\Example\SomeExtension;
use Phpactor202301\Phpactor\Extension\ReferenceFinder\Tests\Example\SomeTypeLocator;
use Phpactor202301\Phpactor\ReferenceFinder\ChainDefinitionLocationProvider;
use Phpactor202301\Phpactor\ReferenceFinder\ChainTypeLocator;
use Phpactor202301\Phpactor\ReferenceFinder\ClassImplementationFinder;
use Phpactor202301\Phpactor\ReferenceFinder\DefinitionLocator;
use Phpactor202301\Phpactor\ReferenceFinder\ReferenceFinder;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
class ReferenceFinderExtensionTest extends TestCase
{
    public function testEmptyChainDefinitionLocator() : void
    {
        $container = PhpactorContainer::fromExtensions([ReferenceFinderExtension::class, LoggingExtension::class]);
        $locator = $container->get(ReferenceFinderExtension::SERVICE_DEFINITION_LOCATOR);
        $this->assertInstanceOf(ChainDefinitionLocationProvider::class, $locator);
    }
    public function testChainDefinitionLocatorLocatorWithRegisteredLocators() : void
    {
        $container = PhpactorContainer::fromExtensions([ReferenceFinderExtension::class, SomeExtension::class, LoggingExtension::class]);
        $locator = $container->get(ReferenceFinderExtension::SERVICE_DEFINITION_LOCATOR);
        \assert($locator instanceof DefinitionLocator);
        $this->assertInstanceOf(ChainDefinitionLocationProvider::class, $locator);
        $location = $locator->locateDefinition(TextDocumentBuilder::create('asd')->build(), ByteOffset::fromInt(1));
        $location = $location->first()->location();
        $this->assertEquals(SomeDefinitionLocator::EXAMPLE_OFFSET, $location->offset()->toInt());
        $this->assertEquals(SomeDefinitionLocator::EXAMPLE_PATH, $location->uri()->path());
    }
    public function testEmptyChainTypeLocator() : void
    {
        $container = PhpactorContainer::fromExtensions([ReferenceFinderExtension::class, LoggingExtension::class]);
        $locator = $container->get(ReferenceFinderExtension::SERVICE_TYPE_LOCATOR);
        $this->assertInstanceOf(ChainTypeLocator::class, $locator);
    }
    public function testChainLocatorLocatorWithRegisteredLocators() : void
    {
        $container = PhpactorContainer::fromExtensions([ReferenceFinderExtension::class, SomeExtension::class, LoggingExtension::class]);
        $locator = $container->get(ReferenceFinderExtension::SERVICE_TYPE_LOCATOR);
        $this->assertInstanceOf(ChainTypeLocator::class, $locator);
        $location = $locator->locateTypes(TextDocumentBuilder::create('asd')->build(), ByteOffset::fromInt(1))->first();
        $this->assertEquals(SomeTypeLocator::EXAMPLE_OFFSET, $location->location()->offset()->toInt());
        $this->assertEquals(SomeTypeLocator::EXAMPLE_PATH, $location->location()->uri()->path());
    }
    public function testReturnsImplementationFinder() : void
    {
        $container = PhpactorContainer::fromExtensions([ReferenceFinderExtension::class, SomeExtension::class, LoggingExtension::class]);
        $finder = $container->get(ReferenceFinderExtension::SERVICE_IMPLEMENTATION_FINDER);
        $this->assertInstanceOf(ClassImplementationFinder::class, $finder);
    }
    public function testReturnsReferenceFinder() : void
    {
        $container = PhpactorContainer::fromExtensions([ReferenceFinderExtension::class, SomeExtension::class, LoggingExtension::class]);
        $finder = $container->get(ReferenceFinder::class);
        $this->assertInstanceOf(ReferenceFinder::class, $finder);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\ReferenceFinder\\Tests\\Unit\\ReferenceFinderExtensionTest', 'Phpactor\\Extension\\ReferenceFinder\\Tests\\Unit\\ReferenceFinderExtensionTest', \false);
