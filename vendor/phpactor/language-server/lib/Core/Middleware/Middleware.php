<?php

namespace Phpactor\LanguageServer\Core\Middleware;

use Phpactor202301\Amp\Promise;
use Phpactor\LanguageServer\Core\Rpc\Message;
use Phpactor\LanguageServer\Core\Rpc\ResponseMessage;
interface Middleware
{
    /**
     * @return Promise<ResponseMessage|null>
     */
    public function process(Message $request, \Phpactor\LanguageServer\Core\Middleware\RequestHandler $handler) : Promise;
}
