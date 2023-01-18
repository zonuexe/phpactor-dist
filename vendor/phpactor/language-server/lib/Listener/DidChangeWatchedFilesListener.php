<?php

namespace Phpactor202301\Phpactor\LanguageServer\Listener;

use Phpactor202301\Phpactor\LanguageServerProtocol\ClientCapabilities;
use Phpactor202301\Phpactor\LanguageServerProtocol\DidChangeWatchedFilesRegistrationOptions;
use Phpactor202301\Phpactor\LanguageServerProtocol\FileSystemWatcher;
use Phpactor202301\Phpactor\LanguageServerProtocol\Registration;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\LanguageServer\Event\Initialized;
use Phpactor202301\Psr\EventDispatcher\ListenerProviderInterface;
use Phpactor202301\Ramsey\Uuid\Uuid;
use function Phpactor202301\Amp\asyncCall;
class DidChangeWatchedFilesListener implements ListenerProviderInterface
{
    /**
     * @var ClientApi
     */
    private $client;
    /**
     * @var array
     */
    private $globPatterns;
    /**
     * @var ClientCapabilities
     */
    private $clientCapabilities;
    public function __construct(ClientApi $client, array $globPatterns, ClientCapabilities $clientCapabilities)
    {
        $this->client = $client;
        $this->globPatterns = $globPatterns;
        $this->clientCapabilities = $clientCapabilities;
    }
    /**
     * {@inheritDoc}
     */
    public function getListenersForEvent(object $event) : iterable
    {
        if ($event instanceof Initialized) {
            return [[$this, 'registerCapability']];
        }
        return [];
    }
    public function registerCapability(Initialized $initialized) : void
    {
        if (!($this->clientCapabilities->workspace['didChangeWatchedFiles']['dynamicRegistration'] ?? \false)) {
            return;
        }
        asyncCall(function () {
            (yield $this->client->client()->registerCapability(new Registration(Uuid::uuid4()->__toString(), 'workspace/didChangeWatchedFiles', new DidChangeWatchedFilesRegistrationOptions(\array_map(function (string $glob) {
                return new FileSystemWatcher($glob);
            }, $this->globPatterns)))));
        });
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Listener\\DidChangeWatchedFilesListener', 'Phpactor\\LanguageServer\\Listener\\DidChangeWatchedFilesListener', \false);
