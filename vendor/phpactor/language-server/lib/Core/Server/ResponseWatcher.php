<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Server;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\ResponseMessage;
interface ResponseWatcher
{
    public function handle(ResponseMessage $response) : void;
    /**
     * @param int|string $requestId
     * @return Promise<ResponseMessage>
     */
    public function waitForResponse($requestId) : Promise;
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Server\\ResponseWatcher', 'Phpactor\\LanguageServer\\Core\\Server\\ResponseWatcher', \false);
