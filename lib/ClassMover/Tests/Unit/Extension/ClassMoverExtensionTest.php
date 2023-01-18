<?php

namespace Phpactor202301\Phpactor\ClassMover\Tests\Unit\Extension;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\ClassMover\ClassMover;
use Phpactor202301\Phpactor\ClassMover\Extension\ClassMoverExtension;
use Phpactor202301\Phpactor\Container\PhpactorContainer;
use Phpactor202301\Phpactor\Extension\CodeTransform\CodeTransformExtension;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\Php\PhpExtension;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
class ClassMoverExtensionTest extends TestCase
{
    public function testBoot() : void
    {
        $container = PhpactorContainer::fromExtensions([ClassMoverExtension::class, CodeTransformExtension::class, FilePathResolverExtension::class, LoggingExtension::class, PhpExtension::class, WorseReflectionExtension::class], [FilePathResolverExtension::PARAM_APPLICATION_ROOT => \realpath(__DIR__ . '/..'), CodeTransformExtension::PARAM_TEMPLATE_PATHS => []]);
        self::assertInstanceOf(ClassMover::class, $container->get(ClassMover::class));
    }
}
\class_alias('Phpactor202301\\Phpactor\\ClassMover\\Tests\\Unit\\Extension\\ClassMoverExtensionTest', 'Phpactor\\ClassMover\\Tests\\Unit\\Extension\\ClassMoverExtensionTest', \false);
