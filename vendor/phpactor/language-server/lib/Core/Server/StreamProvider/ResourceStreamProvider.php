<?php

namespace Phpactor\LanguageServer\Core\Server\StreamProvider;

use PhpactorDist\Amp\Promise;
use PhpactorDist\Amp\Success;
use Phpactor\LanguageServer\Core\Server\Stream\ResourceDuplexStream;
use PhpactorDist\Psr\Log\LoggerInterface;
final class ResourceStreamProvider implements \Phpactor\LanguageServer\Core\Server\StreamProvider\StreamProvider
{
    /**
     * @var ResourceDuplexStream
     */
    private $duplexStream;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var bool
     */
    private $provided = \false;
    public function __construct(ResourceDuplexStream $duplexStream, LoggerInterface $logger)
    {
        $this->duplexStream = $duplexStream;
        $this->logger = $logger;
    }
    /**
     * @return Success<null|Connection>
     */
    public function accept() : Promise
    {
        // resource connections are valid only for
        // the length of the client connnection
        if ($this->provided) {
            return new Success(null);
        }
        $this->provided = \true;
        $this->logger->info('Listening on STDIO');
        return new Success(new \Phpactor\LanguageServer\Core\Server\StreamProvider\Connection('stdio', $this->duplexStream));
    }
    public function close() : void
    {
        $this->duplexStream->close();
    }
}
