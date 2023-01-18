<?php

namespace Phpactor202301\Phpactor\Extension\Logger\Tests\Unit;

use Phpactor202301\Monolog\Formatter\JsonFormatter;
use Phpactor202301\Monolog\Handler\FingersCrossedHandler;
use Phpactor202301\Monolog\Handler\NullHandler;
use Phpactor202301\Monolog\Handler\StreamHandler;
use Phpactor202301\Monolog\Logger;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Container\PhpactorContainer;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
class LoggingExtensionTest extends TestCase
{
    public function testLoggingDisabled() : void
    {
        $container = $this->create([LoggingExtension::PARAM_ENABLED => \false]);
        $logger = $container->get('logging.logger');
        \assert($logger instanceof Logger);
        $handlers = $logger->getHandlers();
        $this->assertCount(1, $handlers);
        $this->assertInstanceOf(NullHandler::class, $handlers[0]);
    }
    /**
     * @dataProvider provideLoggingFormatters
     */
    public function testLoggingFormatters(string $formatter) : void
    {
        $container = $this->create([LoggingExtension::PARAM_ENABLED => \true]);
        $logger = $container->get('logging.logger');
        \assert($logger instanceof Logger);
        $handlers = $logger->getHandlers();
        $this->assertCount(1, $handlers);
        $this->assertInstanceOf(StreamHandler::class, $handlers[0]);
    }
    public function provideLoggingFormatters()
    {
        (yield ['line']);
        (yield ['json']);
        (yield ['pretty']);
    }
    public function testFingersCrossed() : void
    {
        $container = $this->create([LoggingExtension::PARAM_ENABLED => \true, LoggingExtension::PARAM_FINGERS_CROSSED => \true]);
        $logger = $container->get('logging.logger');
        \assert($logger instanceof Logger);
        $handlers = $logger->getHandlers();
        $this->assertCount(1, $handlers);
        $this->assertInstanceOf(FingersCrossedHandler::class, $handlers[0]);
    }
    public function testCustomFormatter() : void
    {
        $fname = \tempnam(\sys_get_temp_dir(), 'phpactor_test');
        $container = $this->create([LoggingExtension::PARAM_FORMATTER => 'json', LoggingExtension::PARAM_ENABLED => \true, LoggingExtension::PARAM_PATH => $fname, LoggingExtension::PARAM_LEVEL => 'debug']);
        $logger = $container->get('logging.logger');
        \assert($logger instanceof Logger);
        $logger->info('asd');
        $result = \json_decode(\file_get_contents($fname));
        $this->assertNotNull($result, 'Decoded JSON');
        \unlink($fname);
    }
    private function create(array $options) : Container
    {
        $container = PhpactorContainer::fromExtensions([LoggingExtension::class, ExampleExtension::class], $options);
        return $container;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Logger\\Tests\\Unit\\LoggingExtensionTest', 'Phpactor\\Extension\\Logger\\Tests\\Unit\\LoggingExtensionTest', \false);
class ExampleExtension implements Extension
{
    public function load(ContainerBuilder $container) : void
    {
        $container->register('json_formatter', function (Container $container) {
            return new JsonFormatter();
        }, [LoggingExtension::TAG_FORMATTER => ['alias' => 'json2']]);
    }
    public function configure(Resolver $schema) : void
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Logger\\Tests\\Unit\\ExampleExtension', 'Phpactor\\Extension\\Logger\\Tests\\Unit\\ExampleExtension', \false);
