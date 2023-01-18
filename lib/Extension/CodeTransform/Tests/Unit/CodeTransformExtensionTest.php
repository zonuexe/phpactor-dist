<?php

namespace Phpactor202301\Phpactor\Extension\CodeTransform\Tests\Unit;

use Generator;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\CodeTransform\Adapter\Native\GenerateNew\ClassGenerator;
use Phpactor202301\Phpactor\CodeTransform\Domain\ClassName;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\PhpactorContainer;
use Phpactor202301\Phpactor\Extension\ClassToFile\ClassToFileExtension;
use Phpactor202301\Phpactor\Extension\CodeTransform\CodeTransformExtension;
use Phpactor202301\Phpactor\Extension\ComposerAutoloader\ComposerAutoloaderExtension;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\Php\PhpExtension;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
class CodeTransformExtensionTest extends TestCase
{
    public function testLoadServices() : void
    {
        $container = $this->createContainer();
        foreach ($container->getServiceIds() as $serviceId) {
            $service = $container->get($serviceId);
        }
        $this->addToAssertionCount(1);
    }
    /**
     * @dataProvider provideClassNew
     */
    public function testClassNew(string $variant) : void
    {
        /** @var array<string,ClassGenerator> */
        $generators = $this->createContainer()->get('code_transform_extra.class_generator.variants');
        self::assertArrayHasKey($variant, $generators);
        $generators[$variant]->generateNew(ClassName::fromString('Foo'));
    }
    /**
     * @return Generator<mixed>
     */
    public function provideClassNew() : Generator
    {
        (yield ['default']);
        (yield ['interface']);
        (yield ['enum']);
        (yield ['trait']);
    }
    private function createContainer() : Container
    {
        $container = PhpactorContainer::fromExtensions([CodeTransformExtension::class, ClassToFileExtension::class, ComposerAutoloaderExtension::class, FilePathResolverExtension::class, LoggingExtension::class, PhpExtension::class, WorseReflectionExtension::class], [CodeTransformExtension::PARAM_TEMPLATE_PATHS => [__DIR__ . '/../../../../../templates/code'], FilePathResolverExtension::PARAM_APPLICATION_ROOT => __DIR__]);
        return $container;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\CodeTransform\\Tests\\Unit\\CodeTransformExtensionTest', 'Phpactor\\Extension\\CodeTransform\\Tests\\Unit\\CodeTransformExtensionTest', \false);
