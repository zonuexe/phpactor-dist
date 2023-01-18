<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Rpc;

final class RawMessage
{
    /**
     * @var array
     */
    private $headers;
    /**
     * @var array
     */
    private $body;
    public function __construct(array $headers, array $body)
    {
        $this->headers = $headers;
        $this->body = $body;
    }
    public function body() : array
    {
        return $this->body;
    }
    public function headers() : array
    {
        return $this->headers;
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Rpc\\RawMessage', 'Phpactor\\LanguageServer\\Core\\Rpc\\RawMessage', \false);
