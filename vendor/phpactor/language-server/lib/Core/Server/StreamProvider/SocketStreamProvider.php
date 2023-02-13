<?php

namespace Phpactor\LanguageServer\Core\Server\StreamProvider;

use PhpactorDist\Amp\Deferred;
use PhpactorDist\Amp\Promise;
use PhpactorDist\Amp\Socket\Server;
use PhpactorDist\Amp\Socket\Socket;
use Phpactor\LanguageServer\Core\Server\Stream\SocketDuplexStream;
use PhpactorDist\Psr\Log\LoggerInterface;
use Throwable;
final class SocketStreamProvider implements \Phpactor\LanguageServer\Core\Server\StreamProvider\StreamProvider
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
        $promise->onResolve(function (?Throwable $reason, mixed $socket) use($deferred) : void {
            if (!$socket instanceof Socket) {
                return;
            }
            $this->logger->info(\sprintf('Accepted connection from "%s"', $socket->getRemoteAddress()));
            $deferred->resolve(new \Phpactor\LanguageServer\Core\Server\StreamProvider\Connection($socket->getRemoteAddress(), new SocketDuplexStream($socket)));
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
