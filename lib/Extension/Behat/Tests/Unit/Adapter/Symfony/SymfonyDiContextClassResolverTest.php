<?php

namespace Phpactor202301\Phpactor\Extension\Behat\Tests\Unit\Adapter\Symfony;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\Behat\Adapter\Symfony\SymfonyDiContextClassResolver;
use Phpactor202301\Phpactor\Extension\Behat\Behat\Exception\CouldNotResolverContextClass;
use RuntimeException;
class SymfonyDiContextClassResolverTest extends TestCase
{
    public function testLocateClass() : void
    {
        self::assertEquals('Phpactor202301\\App\\Tests\\Context\\Transform\\ShippingMethodContext', (new SymfonyDiContextClassResolver(__DIR__ . '/example/example.xml'))->resolve('app.behat.context.transform.shipping_method'));
    }
    public function testExceptionWhenCannotLocate() : void
    {
        $this->expectException(CouldNotResolverContextClass::class);
        (new SymfonyDiContextClassResolver(__DIR__ . '/example/example.xml'))->resolve('app.no');
    }
    public function testWhenFileNotFound() : void
    {
        $this->expectException(RuntimeException::class);
        (new SymfonyDiContextClassResolver(__DIR__ . '/example/not.xml'))->resolve('app.no');
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Behat\\Tests\\Unit\\Adapter\\Symfony\\SymfonyDiContextClassResolverTest', 'Phpactor\\Extension\\Behat\\Tests\\Unit\\Adapter\\Symfony\\SymfonyDiContextClassResolverTest', \false);
