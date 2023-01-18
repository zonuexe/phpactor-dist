<?php

namespace Phpactor202301\Phpactor\LanguageServer;

use Phpactor202301\Amp\ByteStream\ResourceInputStream;
use Phpactor202301\Amp\ByteStream\ResourceOutputStream;
use Phpactor202301\Phpactor\LanguageServerProtocol\ClientCapabilities;
use Phpactor202301\Phpactor\LanguageServerProtocol\InitializeParams;
use Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher\DispatcherFactory;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\Initializer\RequestInitializer;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ServerStats;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\StreamProvider\ResourceStreamProvider;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\StreamProvider\SocketStreamProvider;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\Stream\ResourceDuplexStream;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\LanguageServer;
use Phpactor202301\Phpactor\LanguageServer\Test\LanguageServerTester;
use Phpactor202301\Psr\Log\LoggerInterface;
use Phpactor202301\Psr\Log\NullLogger;
final class LanguageServerBuilder
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var string|null
     */
    private $tcpAddress = null;
    /**
     * @var DispatcherFactory
     */
    private $dispatcherFactory;
    /**
     * @var ServerStats|null
     */
    private $stats = null;
    private function __construct(DispatcherFactory $dispatcherFactory, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->dispatcherFactory = $dispatcherFactory;
    }
    /**
     * Create a new instance of the builder \o/
     */
    public static function create(DispatcherFactory $dispatcherFactory, LoggerInterface $logger = null) : self
    {
        return new self($dispatcherFactory, $logger ?: new NullLogger());
    }
    /**
     * Start a TCP server on the given address.
     *
     * The TCP server can handle multiple connections/sessions, but must be
     * started manually before clients can connect to it.
     *
     * The TCP server is valuable for development and for debugging as it echos
     * the debug information to STDERR.
     *
     * Note that the default behavior is to start a STDIO server.
     */
    public function tcpServer(?string $address = '0.0.0.0:0') : self
    {
        $this->tcpAddress = $address;
        return $this;
    }
    /**
     * Return a language server tester based on the current dispatcher.
     *
     * This is useful for integration testing scenarios.
     */
    public function tester(?InitializeParams $params = null) : LanguageServerTester
    {
        $params = $params ?: new InitializeParams(new ClientCapabilities());
        return new LanguageServerTester($this->dispatcherFactory, $params);
    }
    public function withServerStats(ServerStats $stats) : self
    {
        $this->stats = $stats;
        return $this;
    }
    /**
     * Build the language server.
     *
     * The returned language server instance can then be started by calling
     * start().
     */
    public function build() : LanguageServer
    {
        if ($this->tcpAddress) {
            $provider = new SocketStreamProvider(\Phpactor202301\Amp\Socket\listen($this->tcpAddress), $this->logger);
        } else {
            $provider = new ResourceStreamProvider(new ResourceDuplexStream(new ResourceInputStream(\STDIN), new ResourceOutputStream(\STDOUT)), $this->logger);
        }
        return new LanguageServer($this->dispatcherFactory, $this->logger, $provider, new RequestInitializer(), $this->stats ?: new ServerStats());
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\LanguageServerBuilder', 'Phpactor\\LanguageServer\\LanguageServerBuilder', \false);
