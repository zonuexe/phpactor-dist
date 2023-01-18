<?php

namespace Phpactor202301\Amp\Socket;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
/**
 * Connector that connects to a statically defined URI instead of the URI passed to the connect() call.
 */
final class StaticConnector implements Connector
{
    private $uri;
    private $connector;
    public function __construct(string $uri, Connector $connector)
    {
        $this->uri = $uri;
        $this->connector = $connector;
    }
    public function connect(string $uri, ?ConnectContext $context = null, ?CancellationToken $token = null) : Promise
    {
        return $this->connector->connect($this->uri, $context, $token);
    }
}
