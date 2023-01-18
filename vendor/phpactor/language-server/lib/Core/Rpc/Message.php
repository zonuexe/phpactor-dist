<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Rpc;

abstract class Message
{
    /**
     * @var string
     */
    public $jsonrpc = '2.0';
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Rpc\\Message', 'Phpactor\\LanguageServer\\Core\\Rpc\\Message', \false);
