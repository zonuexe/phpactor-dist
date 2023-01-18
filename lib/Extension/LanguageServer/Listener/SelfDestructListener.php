<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServer\Listener;

use Phpactor202301\Phpactor\LanguageServer\Core\Server\Exception\ExitSession;
use Phpactor202301\Phpactor\LanguageServer\Event\WillShutdown;
use Phpactor202301\Psr\EventDispatcher\ListenerProviderInterface;
use function Phpactor202301\Amp\asyncCall;
use function Phpactor202301\Amp\delay;
class SelfDestructListener implements ListenerProviderInterface
{
    public function __construct(private int $selfDestructTimeout)
    {
    }
    /**
     * @return array<callable>
     */
    public function getListenersForEvent(object $event) : iterable
    {
        if ($event instanceof WillShutdown) {
            return [[$this, 'handleShutdown']];
        }
        return [];
    }
    public function handleShutdown(WillShutdown $willShutdown) : void
    {
        asyncCall(function () {
            (yield delay($this->selfDestructTimeout));
            throw new ExitSession(\sprintf('Waited "%s" seconds after shutdown request for exit notification but did not get one so I\'m self destructing.', $this->selfDestructTimeout));
        });
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServer\\Listener\\SelfDestructListener', 'Phpactor\\Extension\\LanguageServer\\Listener\\SelfDestructListener', \false);