<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Server\Stream;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Socket\Socket;
final class SocketDuplexStream implements DuplexStream
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
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Server\\Stream\\SocketDuplexStream', 'Phpactor\\LanguageServer\\Core\\Server\\Stream\\SocketDuplexStream', \false);
