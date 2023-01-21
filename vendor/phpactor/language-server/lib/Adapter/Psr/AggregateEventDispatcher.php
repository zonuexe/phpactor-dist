<?php

namespace Phpactor\LanguageServer\Adapter\Psr;

use Phpactor202301\Psr\EventDispatcher\EventDispatcherInterface;
use Phpactor202301\Psr\EventDispatcher\ListenerProviderInterface;
class AggregateEventDispatcher implements EventDispatcherInterface
{
    /**
     * @var array<ListenerProviderInterface>
     */
    private $listnerProviders;
    public function __construct(ListenerProviderInterface ...$listnerProviders)
    {
        $this->listnerProviders = $listnerProviders;
    }
    /**
     * {@inheritDoc}
     */
    public function dispatch(object $event)
    {
        foreach ($this->listnerProviders as $provider) {
            foreach ($provider->getListenersForEvent($event) as $listener) {
                $listener($event);
            }
        }
        return $event;
    }
}
