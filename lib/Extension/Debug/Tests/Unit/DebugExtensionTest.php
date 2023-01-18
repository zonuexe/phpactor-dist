<?php

namespace Phpactor202301\Phpactor\Extension\Debug\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Container\PhpactorContainer;
use Phpactor202301\Phpactor\Extension\Debug\DebugExtension;
class DebugExtensionTest extends TestCase
{
    public function testExtension() : void
    {
        $container = PhpactorContainer::fromExtensions([DebugExtension::class]);
        foreach ($container->getServiceIds() as $serviceId) {
            $container->get($serviceId);
        }
        $this->addToAssertionCount(1);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Debug\\Tests\\Unit\\DebugExtensionTest', 'Phpactor\\Extension\\Debug\\Tests\\Unit\\DebugExtensionTest', \false);
