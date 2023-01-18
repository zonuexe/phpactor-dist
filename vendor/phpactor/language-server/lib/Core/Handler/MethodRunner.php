<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Handler;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\Message;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\ResponseMessage;
interface MethodRunner
{
    /**
     * @return Promise<ResponseMessage|null>
     */
    public function dispatch(Message $request) : Promise;
    /**
     * @param int|string $id
     */
    public function cancelRequest($id) : void;
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Handler\\MethodRunner', 'Phpactor\\LanguageServer\\Core\\Handler\\MethodRunner', \false);
