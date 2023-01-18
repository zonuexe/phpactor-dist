<?php

namespace Phpactor202301\Phpactor\Extension\Logger\Formatter;

use Phpactor202301\Monolog\Formatter\FormatterInterface;
use Phpactor202301\Psr\Container\ContainerInterface;
use RuntimeException;
class FormatterRegistry
{
    public function __construct(private ContainerInterface $container, private array $serviceMap)
    {
    }
    public function get(string $alias) : FormatterInterface
    {
        if (!isset($this->serviceMap[$alias])) {
            throw new RuntimeException(\sprintf('Could not find formatter with alias "%s", known formatters: "%s"', $alias, \implode('", "', \array_keys($this->serviceMap))));
        }
        return $this->container->get($this->serviceMap[$alias]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Logger\\Formatter\\FormatterRegistry', 'Phpactor\\Extension\\Logger\\Formatter\\FormatterRegistry', \false);
