<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Server;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\ResponseMessage;
interface RpcClient
{
    public function notification(string $method, array $params) : void;
    /**
     * @return Promise<ResponseMessage>
     */
    public function request(string $method, array $params) : Promise;
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Server\\RpcClient', 'Phpactor\\LanguageServer\\Core\\Server\\RpcClient', \false);
