<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Server;

use Phpactor202301\Phpactor\LanguageServerProtocol\InitializeParams;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\Message;
interface Initializer
{
    /**
     * Provide initialization parameters.
     *
     * Typically implementations will be passed the _first request_ to the
     * language server session, which should be the initialization request from
     * which the initialize parameters can be extracted (including the
     * ClientCapabilities).
     */
    public function provideInitializeParams(Message $message) : InitializeParams;
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Server\\Initializer', 'Phpactor\\LanguageServer\\Core\\Server\\Initializer', \false);
