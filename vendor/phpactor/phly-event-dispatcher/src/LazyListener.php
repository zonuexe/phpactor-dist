<?php

/**
 * @see       https://github.com/phly/phly-event-dispatcher for the canonical source repository
 * @copyright Copyright (c) 2018-2019 Matthew Weier O'Phinney (https:/mwop.net)
 * @license   https://github.com/phly/phly-event-dispatcher/blob/master/LICENSE.md New BSD License
 */
declare (strict_types=1);
namespace Phpactor202301\Phly\EventDispatcher;

use Phpactor202301\Psr\Container\ContainerInterface;
final class LazyListener
{
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var ?string
     */
    private $method = null;
    /**
     * @var string
     */
    private $service;
    public function __construct(ContainerInterface $container, string $service, string $method = null)
    {
        $this->container = $container;
        $this->service = $service;
        $this->method = $method;
    }
    /**
     * {@inheritDoc}
     */
    public function __invoke(object $event) : void
    {
        $listener = $this->getListener($this->container->get($this->service));
        $listener($event);
    }
    /**
     * @var mixed $service Service retrieved from container.
     */
    private function getListener($service) : callable
    {
        // Not an object, and not callable: invalid
        if (!\is_object($service) && !\is_callable($service)) {
            throw Exception\InvalidListenerException::forNonCallableService($service);
        }
        // Not an object, but callable: return verbatim
        if (!\is_object($service) && \is_callable($service)) {
            return $service;
        }
        // Object, no method present, and not callable: invalid
        if (!$this->method && !\is_callable($service)) {
            throw Exception\InvalidListenerException::forNonCallableInstance($service);
        }
        // Object, no method present, not a listener, but callable: return verbatim
        if (!$this->method && \is_callable($service)) {
            return $service;
        }
        $callback = [$service, $this->method];
        // Object, method present, but method is not callable: invalid
        if (!\is_callable($callback)) {
            throw Exception\InvalidListenerException::forNonCallableInstanceMethod($service, $this->method);
        }
        // Object with method as callback
        return $callback;
    }
}
