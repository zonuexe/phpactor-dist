<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Server\StreamProvider;

use Phpactor202301\Amp\Promise;
interface StreamProvider
{
    /**
     * @return Promise<Connection|null>
     */
    public function accept() : Promise;
    public function close() : void;
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Server\\StreamProvider\\StreamProvider', 'Phpactor\\LanguageServer\\Core\\Server\\StreamProvider\\StreamProvider', \false);
