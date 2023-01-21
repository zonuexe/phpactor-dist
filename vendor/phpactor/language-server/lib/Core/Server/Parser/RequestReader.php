<?php

namespace Phpactor\LanguageServer\Core\Server\Parser;

use Phpactor202301\Amp\Promise;
use Phpactor\LanguageServer\Core\Rpc\RawMessage;
interface RequestReader
{
    /**
     * @return Promise<RawMessage|null>
     */
    public function wait() : Promise;
}
