<?php

namespace Phpactor202301\Phpactor\LanguageServer\Adapter\Psr;

use Phpactor202301\Psr\EventDispatcher\EventDispatcherInterface;
final class NullEventDispatcher implements EventDispatcherInterface
{
    public function dispatch(object $event)
    {
        return $event;
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Adapter\\Psr\\NullEventDispatcher', 'Phpactor\\LanguageServer\\Adapter\\Psr\\NullEventDispatcher', \false);
