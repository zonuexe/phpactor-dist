<?php

namespace Phpactor202301\Phpactor\Extension\Logger\Tests\Unit\Formatter;

use Phpactor202301\Monolog\Formatter\FormatterInterface;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\Logger\Formatter\FormatterRegistry;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use Phpactor202301\Psr\Container\ContainerInterface;
use RuntimeException;
class FormatterRegistryTest extends TestCase
{
    use ProphecyTrait;
    public function testThrowsExceptionIfFormatterNotFound() : void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Could not find formatter');
        $container = $this->prophesize(ContainerInterface::class);
        $registry = new FormatterRegistry($container->reveal(), ['foo' => 'bar']);
        $registry->get('zed');
    }
    public function testReturnsFormatter() : void
    {
        $container = $this->prophesize(ContainerInterface::class);
        $formatter = $this->prophesize(FormatterInterface::class);
        $registry = new FormatterRegistry($container->reveal(), ['foo' => 'bar']);
        $container->get('bar')->willReturn($formatter->reveal());
        $this->assertSame($formatter->reveal(), $registry->get('foo'));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Logger\\Tests\\Unit\\Formatter\\FormatterRegistryTest', 'Phpactor\\Extension\\Logger\\Tests\\Unit\\Formatter\\FormatterRegistryTest', \false);
