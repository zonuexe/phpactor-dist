<?php

namespace Phpactor\LanguageServer\Core\Server\Stream;

use PhpactorDist\Amp\Promise;
use PhpactorDist\Amp\Socket\Socket;
final class SocketDuplexStream implements \Phpactor\LanguageServer\Core\Server\Stream\DuplexStream
{
    /**
     * @var Socket
     */
    private $socket;
    public function __construct(Socket $socket)
    {
        $this->socket = $socket;
    }
    /**
     * @return Promise<string|null>
     */
    public function read() : Promise
    {
        return $this->socket->read();
    }
    /**
     * @return Promise<void>
     */
    public function write(string $data) : Promise
    {
        return $this->socket->write($data);
    }
    /**
     * @return Promise<void>
     */
    public function end(string $finalData = '') : Promise
    {
        return $this->socket->end($finalData);
    }
}
