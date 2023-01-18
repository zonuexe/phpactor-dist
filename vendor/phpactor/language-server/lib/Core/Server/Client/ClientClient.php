<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Server\Client;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServerProtocol\Registration;
use Phpactor202301\Phpactor\LanguageServerProtocol\Unregistration;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\ResponseMessage;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\RpcClient;
final class ClientClient
{
    /**
     * @var RpcClient
     */
    private $client;
    public function __construct(RpcClient $client)
    {
        $this->client = $client;
    }
    /**
     * @return Promise<ResponseMessage>
     */
    public function registerCapability(Registration ...$registrations) : Promise
    {
        return $this->client->request('client/registerCapability', ['registrations' => $registrations]);
    }
    /**
     * @return Promise<ResponseMessage>
     */
    public function unregisterCapability(Unregistration ...$unregistrations) : Promise
    {
        return $this->client->request('client/unregisterCapability', ['unregistrations' => $unregistrations]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Server\\Client\\ClientClient', 'Phpactor\\LanguageServer\\Core\\Server\\Client\\ClientClient', \false);
