<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Server\StreamProvider;

use Phpactor202301\Amp\Deferred;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Socket\Server;
use Phpactor202301\Amp\Socket\Socket;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\Stream\SocketDuplexStream;
use Phpactor202301\Psr\Log\LoggerInterface;
final class SocketStreamProvider implements StreamProvider
{
    /**
     * @var Server
     */
    private $server;
    /**
     * @var LoggerInterface
     */
    private $logger;
    public function __construct(Server $server, LoggerInterface $logger)
    {
        $this->server = $server;
        $this->logger = $logger;
    }
    public function accept() : Promise
    {
        $promise = $this->server->accept();
        $deferred = new Deferred();
        $promise->onResolve(function ($reason, ?Socket $socket) use($deferred) : void {
            if (null === $socket) {
                return;
            }
            $this->logger->info(\sprintf('Accepted connection from "%s"', $socket->getRemoteAddress()));
            $deferred->resolve(new Connection($socket->getRemoteAddress(), new SocketDuplexStream($socket)));
        });
        return $deferred->promise();
    }
    public function address() : ?string
    {
        return $this->server->getAddress();
    }
    public function close() : void
    {
        $this->server->close();
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Server\\StreamProvider\\SocketStreamProvider', 'Phpactor\\LanguageServer\\Core\\Server\\StreamProvider\\SocketStreamProvider', \false);
