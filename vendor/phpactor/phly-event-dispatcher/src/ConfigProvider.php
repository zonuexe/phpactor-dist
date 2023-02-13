<?php

/**
 * @see       https://github.com/phly/phly-event-dispatcher for the canonical source repository
 * @copyright Copyright (c) 2018 Matthew Weier O'Phinney (https:/mwop.net)
 * @license   https://github.com/phly/phly-event-dispatcher/blob/master/LICENSE.md New BSD License
 */
declare (strict_types=1);
namespace PhpactorDist\Phly\EventDispatcher;

class ConfigProvider
{
    public function __invoke() : array
    {
        return ['dependencies' => $this->getDependencies()];
    }
    public function getDependencies() : array
    {
        return [
            // @codingStandardsIgnoreStart
            // phpcs:disable
            'invokables' => [ListenerProvider\AttachableListenerProvider::class => ListenerProvider\AttachableListenerProvider::class, ListenerProvider\PrioritizedListenerProvider::class => ListenerProvider\PrioritizedListenerProvider::class, ListenerProvider\RandomizedListenerProvider::class => ListenerProvider\RandomizedListenerProvider::class],
            // phpcs:endable
            // @codingStandardsIgnoreEnd
            'factories' => [EventDispatcher::class => EventDispatcherFactory::class, ErrorEmittingDispatcher::class => EventDispatcherFactory::class],
        ];
    }
}
