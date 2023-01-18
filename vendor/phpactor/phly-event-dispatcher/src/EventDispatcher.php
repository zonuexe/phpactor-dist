<?php

/**
 * @see       https://github.com/phly/phly-event-dispatcher for the canonical source repository
 * @copyright Copyright (c) 2018-2019 Matthew Weier O'Phinney (https:/mwop.net)
 * @license   https://github.com/phly/phly-event-dispatcher/blob/master/LICENSE.md New BSD License
 */
declare (strict_types=1);
namespace Phpactor202301\Phly\EventDispatcher;

use Phpactor202301\Psr\EventDispatcher\EventDispatcherInterface;
use Phpactor202301\Psr\EventDispatcher\ListenerProviderInterface;
use Phpactor202301\Psr\EventDispatcher\StoppableEventInterface;
class EventDispatcher implements EventDispatcherInterface
{
    /** @var ListenerProviderInterface */
    private $listenerProvider;
    public function __construct(ListenerProviderInterface $listenerProvider)
    {
        $this->listenerProvider = $listenerProvider;
    }
    /**
     * {@inheritDoc}
     */
    public function dispatch(object $event)
    {
        $stoppable = $event instanceof StoppableEventInterface;
        if ($stoppable && $event->isPropagationStopped()) {
            return $event;
        }
        foreach ($this->listenerProvider->getListenersForEvent($event) as $listener) {
            $listener($event);
            if ($stoppable && $event->isPropagationStopped()) {
                break;
            }
        }
        return $event;
    }
}
