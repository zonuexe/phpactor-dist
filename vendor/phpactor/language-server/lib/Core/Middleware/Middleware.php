<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Middleware;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\Message;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\ResponseMessage;
interface Middleware
{
    /**
     * @return Promise<ResponseMessage|null>
     */
    public function process(Message $request, RequestHandler $handler) : Promise;
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Middleware\\Middleware', 'Phpactor\\LanguageServer\\Core\\Middleware\\Middleware', \false);
