<?php

namespace Phpactor\LanguageServer\Adapter\Psr;

use PhpactorDist\Psr\EventDispatcher\EventDispatcherInterface;
final class NullEventDispatcher implements EventDispatcherInterface
{
    public function dispatch(object $event)
    {
        return $event;
    }
}
