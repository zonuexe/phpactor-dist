<?php

namespace Phpactor\Extension\LanguageServer\Listener;

use Phpactor\LanguageServer\Core\Server\Exception\ExitSession;
use Phpactor\LanguageServer\Event\WillShutdown;
use PhpactorDist\Psr\EventDispatcher\ListenerProviderInterface;
use function PhpactorDist\Amp\asyncCall;
use function PhpactorDist\Amp\delay;
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
            /** @phpstan-ignore-next-line */
            (yield delay($this->selfDestructTimeout));
            throw new ExitSession(\sprintf('Waited "%s" seconds after shutdown request for exit notification but did not get one so I\'m self destructing.', $this->selfDestructTimeout));
        });
    }
}
