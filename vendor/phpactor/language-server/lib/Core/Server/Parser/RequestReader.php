<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Server\Parser;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\RawMessage;
interface RequestReader
{
    /**
     * @return Promise<RawMessage|null>
     */
    public function wait() : Promise;
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Server\\Parser\\RequestReader', 'Phpactor\\LanguageServer\\Core\\Server\\Parser\\RequestReader', \false);
