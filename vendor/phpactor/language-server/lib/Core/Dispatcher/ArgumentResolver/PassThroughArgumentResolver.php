<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher\ArgumentResolver;

use Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher\ArgumentResolver;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\Message;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\NotificationMessage;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\RequestMessage;
final class PassThroughArgumentResolver implements ArgumentResolver
{
    /**
     * {@inheritDoc}
     */
    public function resolveArguments(object $object, string $method, Message $request) : array
    {
        if ($request instanceof RequestMessage || $request instanceof NotificationMessage) {
            return $request->params ?? [];
        }
        return [];
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Dispatcher\\ArgumentResolver\\PassThroughArgumentResolver', 'Phpactor\\LanguageServer\\Core\\Dispatcher\\ArgumentResolver\\PassThroughArgumentResolver', \false);
