<?php

namespace Phpactor\LanguageServer\Core\Server\Client;

use Phpactor\LanguageServer\Core\Server\RpcClient;
final class WindowClient
{
    /**
     * @var RpcClient
     */
    private $client;
    public function __construct(RpcClient $client)
    {
        $this->client = $client;
    }
    public function showMessage() : \Phpactor\LanguageServer\Core\Server\Client\MessageClient
    {
        return new \Phpactor\LanguageServer\Core\Server\Client\MessageClient($this->client, 'window/showMessage');
    }
    public function logMessage() : \Phpactor\LanguageServer\Core\Server\Client\MessageClient
    {
        return new \Phpactor\LanguageServer\Core\Server\Client\MessageClient($this->client, 'window/logMessage');
    }
    public function showMessageRequest() : \Phpactor\LanguageServer\Core\Server\Client\MessageRequestClient
    {
        return new \Phpactor\LanguageServer\Core\Server\Client\MessageRequestClient($this->client);
    }
}
