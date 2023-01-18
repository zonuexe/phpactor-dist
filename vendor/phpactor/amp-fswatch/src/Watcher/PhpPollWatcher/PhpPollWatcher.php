<?php

namespace Phpactor202301\Phpactor\AmpFsWatch\Watcher\PhpPollWatcher;

use Phpactor202301\Amp\Delayed;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use DateTimeImmutable;
use Phpactor202301\Phpactor\AmpFsWatch\ModifiedFile;
use Phpactor202301\Phpactor\AmpFsWatch\ModifiedFileQueue;
use Phpactor202301\Phpactor\AmpFsWatch\Watcher;
use Phpactor202301\Phpactor\AmpFsWatch\WatcherConfig;
use Phpactor202301\Phpactor\AmpFsWatch\WatcherProcess;
use Phpactor202301\Psr\Log\LoggerInterface;
use Phpactor202301\Psr\Log\NullLogger;
use Phpactor202301\Webmozart\PathUtil\Path;
class PhpPollWatcher implements Watcher, WatcherProcess
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var DateTimeImmutable
     */
    private $lastUpdate;
    /**
     * @var WatcherConfig
     */
    private $config;
    /**
     * @var ModifiedFileQueue
     */
    private $queue;
    /**
     * @var bool
     */
    private $running;
    public function __construct(WatcherConfig $config, ?LoggerInterface $logger = null)
    {
        $this->logger = $logger ?: new NullLogger();
        $this->queue = new ModifiedFileQueue();
        $this->config = $config;
    }
    public function watch() : Promise
    {
        return \Phpactor202301\Amp\call(function () {
            $this->logger->info(\sprintf('Polling at interval of "%s" milliseconds for changes paths "%s"', $this->config->pollInterval(), \implode('", "', $this->config->paths())));
            $this->updateDateReference();
            $this->running = \true;
            \Phpactor202301\Amp\asyncCall(function () {
                while ($this->running) {
                    $start = \microtime(\true);
                    $searches = [];
                    foreach ($this->config->paths() as $path) {
                        $searches[] = $this->search($path);
                    }
                    (yield \Phpactor202301\Amp\Promise\all($searches));
                    $this->logger->debug(\sprintf('pid: %s PHP watcher scanned paths "%s" in %s seconds', \getmypid(), \implode('", "', $this->config->paths()), \number_format(\microtime(\true) - $start, 2)));
                    $this->updateDateReference();
                    (yield new Delayed($this->config->pollInterval()));
                }
            });
            return $this;
        });
    }
    public function wait() : Promise
    {
        return \Phpactor202301\Amp\call(function () {
            while ($this->running) {
                $this->queue = $this->queue->compress();
                if ($next = $this->queue->dequeue()) {
                    return $next;
                }
                (yield new Delayed($this->config->pollInterval() / 2));
            }
        });
    }
    public function stop() : void
    {
        $this->running = \false;
    }
    public function isSupported() : Promise
    {
        return new Success(\true);
    }
    /**
     * @return Promise<void>
     */
    private function search(string $path) : Promise
    {
        return \Phpactor202301\Amp\call(function () use($path) {
            $files = \scandir($path);
            foreach ((array) $files as $file) {
                if ($file === '.' || $file === '..') {
                    continue;
                }
                $filePath = Path::join($path, $file);
                \clearstatcache();
                $mtime = \filectime($filePath);
                $isDir = \is_dir($filePath);
                // we are only accurate to seconds, so accept also
                // if mtime is the same as current timestamp
                if ($mtime >= $this->lastUpdate->format('U')) {
                    $this->queue->enqueue(new ModifiedFile($filePath, $isDir ? ModifiedFile::TYPE_FOLDER : ModifiedFile::TYPE_FILE));
                }
                if ($isDir) {
                    (yield $this->search($filePath));
                }
            }
        });
    }
    private function updateDateReference() : void
    {
        $this->lastUpdate = new DateTimeImmutable();
    }
    /**
     * {@inheritDoc}
     */
    public function describe() : string
    {
        return 'php-poll';
    }
}
\class_alias('Phpactor202301\\Phpactor\\AmpFsWatch\\Watcher\\PhpPollWatcher\\PhpPollWatcher', 'Phpactor\\AmpFsWatch\\Watcher\\PhpPollWatcher\\PhpPollWatcher', \false);