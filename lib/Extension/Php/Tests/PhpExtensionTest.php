<?php

namespace Phpactor202301\Phpactor\Extension\Php\Tests;

use Phpactor202301\Phpactor\Container\PhpactorContainer;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\Php\Model\PhpVersionResolver;
use Phpactor202301\Phpactor\Extension\Php\PhpExtension;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
class PhpExtensionTest extends IntegrationTestCase
{
    public function testExtension() : void
    {
        $container = PhpactorContainer::fromExtensions([PhpExtension::class, LoggingExtension::class, FilePathResolverExtension::class]);
        $version = $container->get(PhpVersionResolver::class)->resolve();
        self::assertNotNull($version);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Php\\Tests\\PhpExtensionTest', 'Phpactor\\Extension\\Php\\Tests\\PhpExtensionTest', \false);
