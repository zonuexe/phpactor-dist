<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServer\EventDispatcher;

use Phpactor202301\Phly\EventDispatcher\ListenerProvider\ListenerProviderAggregate;
use Phpactor202301\Psr\Container\ContainerInterface;
use Phpactor202301\Psr\EventDispatcher\ListenerProviderInterface;
use RuntimeException;
class LazyAggregateProvider implements ListenerProviderInterface
{
    private ?ListenerProviderAggregate $aggregateProvider = null;
    public function __construct(private ContainerInterface $container, private array $serviceIds)
    {
    }
    public function getListenersForEvent(object $event) : iterable
    {
        if (null === $this->aggregateProvider) {
            $this->aggregateProvider = new ListenerProviderAggregate();
            foreach ($this->serviceIds as $serviceId) {
                $listenerProvider = $this->container->get($serviceId);
                // if null assume that it was conditionally disabled
                if (null === $listenerProvider) {
                    continue;
                }
                if (!$listenerProvider instanceof ListenerProviderInterface) {
                    throw new RuntimeException(\sprintf('Listener service with ID "%s" must implement ListenerProviderInterface, it is of class "%s"', $serviceId, \get_class($listenerProvider)));
                }
                $this->aggregateProvider->attach($listenerProvider);
            }
        }
        return $this->aggregateProvider->getListenersForEvent($event);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServer\\EventDispatcher\\LazyAggregateProvider', 'Phpactor\\Extension\\LanguageServer\\EventDispatcher\\LazyAggregateProvider', \false);