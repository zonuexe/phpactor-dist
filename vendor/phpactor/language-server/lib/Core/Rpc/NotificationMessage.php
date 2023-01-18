<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Rpc;

final class NotificationMessage extends Message
{
    /**
     * @var string
     */
    public $method;
    /**
     * @var array
     */
    public $params;
    public function __construct(string $method, ?array $params = null)
    {
        $this->method = $method;
        $this->params = $params;
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Rpc\\NotificationMessage', 'Phpactor\\LanguageServer\\Core\\Rpc\\NotificationMessage', \false);
