<?php

namespace Phpactor202301\Phpactor\ObjectRenderer\Adapter\Psr;

use Phpactor202301\Phpactor\ObjectRenderer\Model\Exception\ObjectRendererNotFound;
use Phpactor202301\Phpactor\ObjectRenderer\Model\ObjectRenderer;
use Phpactor202301\Phpactor\ObjectRenderer\Model\ObjectRendererRegistry;
use Phpactor202301\Psr\Container\ContainerInterface;
class ContainerObectRendererRegistry implements ObjectRendererRegistry
{
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var array<string,string>
     */
    private $aliasToServiceMap;
    /**
     * @param array<string,string> $aliasToServiceMap
     */
    public function __construct(ContainerInterface $container, array $aliasToServiceMap)
    {
        $this->container = $container;
        $this->aliasToServiceMap = $aliasToServiceMap;
    }
    /**
     * {@inheritDoc}
     */
    public function get(string $name) : ObjectRenderer
    {
        if (!isset($this->aliasToServiceMap[$name])) {
            throw new ObjectRendererNotFound(\sprintf('Object renderer "%s" not known, known renderers: "%s"', $name, \implode('", "', \array_keys($this->aliasToServiceMap))));
        }
        return $this->container->get($this->aliasToServiceMap[$name]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\ObjectRenderer\\Adapter\\Psr\\ContainerObectRendererRegistry', 'Phpactor\\ObjectRenderer\\Adapter\\Psr\\ContainerObectRendererRegistry', \false);
