<?php

namespace Phpactor\LanguageServer\Core\Server\StreamProvider;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor\LanguageServer\Core\Server\Stream\ResourceDuplexStream;
use Phpactor202301\Psr\Log\LoggerInterface;
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
