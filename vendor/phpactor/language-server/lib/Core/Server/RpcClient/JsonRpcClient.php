<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Server\RpcClient;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\NotificationMessage;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\RequestMessage;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\ResponseMessage;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ResponseWatcher;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\RpcClient;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\Transmitter\MessageTransmitter;
use Phpactor202301\Ramsey\Uuid\Uuid;
final class JsonRpcClient implements RpcClient
{
    /**
     * @var MessageTransmitter
     */
    private $transmitter;
    /**
     * @var ResponseWatcher
     */
    private $responseWatcher;
    public function __construct(MessageTransmitter $transmitter, ResponseWatcher $responseWatcher)
    {
        $this->transmitter = $transmitter;
        $this->responseWatcher = $responseWatcher;
    }
    public function notification(string $method, array $params) : void
    {
        $this->transmitter->transmit(new NotificationMessage($method, $params));
    }
    /**
     * @return Promise<ResponseMessage>
     */
    public function request(string $method, array $params) : Promise
    {
        $requestId = Uuid::uuid4()->__toString();
        $response = $this->responseWatcher->waitForResponse((string) $requestId);
        $this->transmitter->transmit(new RequestMessage($requestId, $method, $params));
        return $response;
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Server\\RpcClient\\JsonRpcClient', 'Phpactor\\LanguageServer\\Core\\Server\\RpcClient\\JsonRpcClient', \false);
