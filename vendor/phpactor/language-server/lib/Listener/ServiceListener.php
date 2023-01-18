<?php

namespace Phpactor202301\Phpactor\LanguageServer\Listener;

use Phpactor202301\Phpactor\LanguageServer\Core\Service\ServiceManager;
use Phpactor202301\Phpactor\LanguageServer\Event\Initialized;
use Phpactor202301\Phpactor\LanguageServer\Event\WillShutdown;
use Phpactor202301\Psr\EventDispatcher\ListenerProviderInterface;
class ServiceListener implements ListenerProviderInterface
{
    /**
     * @var ServiceManager
     */
    private $serviceManager;
    public function __construct(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }
    /**
     * {@inheritDoc}
     */
    public function getListenersForEvent(object $event) : iterable
    {
        if ($event instanceof Initialized) {
            (yield function (Initialized $closed) : void {
                $this->serviceManager->startAll();
            });
            return;
        }
        if ($event instanceof WillShutdown) {
            (yield function (WillShutdown $closed) : void {
                $this->serviceManager->stopAll();
            });
            return;
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Listener\\ServiceListener', 'Phpactor\\LanguageServer\\Listener\\ServiceListener', \false);
