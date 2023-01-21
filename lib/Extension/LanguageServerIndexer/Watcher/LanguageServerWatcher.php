<?php

namespace Phpactor\Extension\LanguageServerIndexer\Watcher;

use Phpactor202301\Amp\Deferred;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor\AmpFsWatch\ModifiedFileBuilder;
use Phpactor\AmpFsWatch\Watcher;
use Phpactor\AmpFsWatch\WatcherProcess;
use Phpactor\LanguageServerProtocol\ClientCapabilities;
use Phpactor\LanguageServerProtocol\FileEvent;
use Phpactor\LanguageServer\Event\FilesChanged;
use Phpactor\TextDocument\TextDocumentUri;
use Phpactor202301\Psr\EventDispatcher\ListenerProviderInterface;
use function Phpactor202301\Amp\call;
class LanguageServerWatcher implements Watcher, WatcherProcess, ListenerProviderInterface
{
    /**
     * @var Deferred<FilesChanged>
     */
    private Deferred $deferred;
    /**
     * @var FileEvent[]
     */
    private array $queue = [];
    private bool $running = \false;
    public function __construct(private ?ClientCapabilities $clientCapabilities)
    {
        $this->deferred = new Deferred();
    }
    public function watch() : Promise
    {
        return new Success($this);
    }
    public function isSupported() : Promise
    {
        if (!$this->clientCapabilities) {
            return new Success(\false);
        }
        return new Success((bool) ($this->clientCapabilities->workspace['didChangeWatchedFiles'] ?? \false));
    }
    public function describe() : string
    {
        return 'LSP file events';
    }
    public function getListenersForEvent(object $event) : iterable
    {
        if ($event instanceof FilesChanged) {
            return [[$this, 'enqueue']];
        }
        return [];
    }
    public function enqueue(FilesChanged $filesChanged) : void
    {
        foreach ($filesChanged->events() as $changedFile) {
            $this->queue[] = $changedFile;
        }
        if (!$this->running) {
            $this->running = \true;
            $this->deferred->resolve();
        }
    }
    public function stop() : void
    {
    }
    public function wait() : Promise
    {
        return call(function () {
            while (\true) {
                (yield $this->deferred->promise());
                $this->running = \false;
                $this->deferred = new Deferred();
                $event = \array_shift($this->queue);
                if ($event === null) {
                    continue;
                }
                break;
            }
            \assert($event instanceof FileEvent);
            if ($this->queue) {
                $this->deferred->resolve();
            }
            return ModifiedFileBuilder::fromPath(TextDocumentUri::fromString($event->uri)->path())->asFile()->build();
        });
    }
}
