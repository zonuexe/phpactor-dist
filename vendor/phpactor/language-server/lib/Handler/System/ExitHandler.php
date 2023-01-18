<?php

namespace Phpactor202301\Phpactor\LanguageServer\Handler\System;

use Phpactor202301\Amp\Delayed;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServer\Adapter\Psr\NullEventDispatcher;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\Handler;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\Exception\ExitSession;
use Phpactor202301\Phpactor\LanguageServer\Event\WillShutdown;
use Phpactor202301\Psr\EventDispatcher\EventDispatcherInterface;
use function Phpactor202301\Amp\call;
class ExitHandler implements Handler
{
    private EventDispatcherInterface $eventDispatcher;
    private int $gracePeriod;
    public function __construct(?EventDispatcherInterface $eventDispatcher = null, int $gracePeriod = 500)
    {
        $this->eventDispatcher = $eventDispatcher ?: new NullEventDispatcher();
        $this->gracePeriod = $gracePeriod;
    }
    public function methods() : array
    {
        return ['shutdown' => 'shutdown', 'exit' => 'exit'];
    }
    /**
     * @return Promise<null>
     */
    public function shutdown() : Promise
    {
        return call(function () {
            $this->eventDispatcher->dispatch(new WillShutdown());
            (yield new Delayed($this->gracePeriod));
        });
    }
    public function exit() : void
    {
        throw new ExitSession('Exit method invoked by client');
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Handler\\System\\ExitHandler', 'Phpactor\\LanguageServer\\Handler\\System\\ExitHandler', \false);