<?php

namespace PhpactorDist\Amp\Socket;

use PhpactorDist\Amp\CancellationToken;
use PhpactorDist\Amp\CancelledException;
use PhpactorDist\Amp\Promise;
interface Connector
{
    /**
     * Asynchronously establish a socket connection to the specified URI.
     *
     * @param string                 $uri URI in scheme://host:port format. TCP is assumed if no scheme is present.
     * @param ConnectContext         $context Socket connect context to use when connecting.
     * @param CancellationToken|null $token
     *
     * @return Promise<EncryptableSocket>
     *
     * @throws ConnectException
     * @throws CancelledException
     */
    public function connect(string $uri, ?ConnectContext $context = null, ?CancellationToken $token = null) : Promise;
}
