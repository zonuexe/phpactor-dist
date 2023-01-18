<?php

/**
 * @see       https://github.com/phly/phly-event-dispatcher for the canonical source repository
 * @copyright Copyright (c) 2018 Matthew Weier O'Phinney (https:/mwop.net)
 * @license   https://github.com/phly/phly-event-dispatcher/blob/master/LICENSE.md New BSD License
 */
declare (strict_types=1);
namespace Phpactor202301\Phly\EventDispatcher;

use Phpactor202301\Psr\Container\ContainerInterface;
use Phpactor202301\Psr\EventDispatcher\EventDispatcherInterface;
use Phpactor202301\Psr\EventDispatcher\ListenerProviderInterface;
/**
 * Create an instance of an EventDispatcherInterface implementation.
 *
 * Uses $serviceName to create an instance, and always passes the service
 * registered for ListenerProviderInterface as the sole argument to the
 * constructor.
 */
class EventDispatcherFactory
{
    public function __invoke(ContainerInterface $container, string $serviceName) : EventDispatcherInterface
    {
        return new $serviceName($container->get(ListenerProviderInterface::class));
    }
}
