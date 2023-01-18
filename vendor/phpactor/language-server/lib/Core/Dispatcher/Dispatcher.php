<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\Message;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\ResponseMessage;
interface Dispatcher
{
    /**
     * @return Promise<ResponseMessage|null>
     */
    public function dispatch(Message $request) : Promise;
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Dispatcher\\Dispatcher', 'Phpactor\\LanguageServer\\Core\\Dispatcher\\Dispatcher', \false);
