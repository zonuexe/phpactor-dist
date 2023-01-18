<?php

/**
 * @see       https://github.com/phly/phly-event-dispatcher for the canonical source repository
 * @copyright Copyright (c) 2018-2019 Matthew Weier O'Phinney (https:/mwop.net)
 * @license   https://github.com/phly/phly-event-dispatcher/blob/master/LICENSE.md New BSD License
 */
declare (strict_types=1);
namespace Phpactor202301\Phly\EventDispatcher\ListenerProvider;

use Phpactor202301\Psr\EventDispatcher\ListenerProviderInterface;
class ListenerProviderAggregate implements ListenerProviderInterface
{
    /**
     * @var ListenerProviderInterface[]
     */
    private $providers = [];
    public function getListenersForEvent(object $event) : iterable
    {
        foreach ($this->providers as $provider) {
            yield from $provider->getListenersForEvent($event);
        }
    }
    public function attach(ListenerProviderInterface $provider) : void
    {
        $this->providers[] = $provider;
    }
}
