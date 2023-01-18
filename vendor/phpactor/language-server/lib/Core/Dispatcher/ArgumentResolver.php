<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher;

use Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher\Exception\CouldNotResolveArguments;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\Message;
interface ArgumentResolver
{
    /**
     * @throws CouldNotResolveArguments
     */
    public function resolveArguments(object $object, string $method, Message $message) : array;
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Dispatcher\\ArgumentResolver', 'Phpactor\\LanguageServer\\Core\\Dispatcher\\ArgumentResolver', \false);
