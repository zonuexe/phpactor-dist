<?php

namespace Phpactor202301\Phpactor\AmpFsWatch\Watcher\FsWatch;

use Phpactor202301\Amp\ByteStream\LineReader;
use Phpactor202301\Amp\Delayed;
use Phpactor202301\Amp\Process\Process;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\AmpFsWatch\ModifiedFileQueue;
use Phpactor202301\Phpactor\AmpFsWatch\SystemDetector\CommandDetector;
use Phpactor202301\Phpactor\AmpFsWatch\ModifiedFileBuilder;
use Phpactor202301\Phpactor\AmpFsWatch\Watcher;
use Phpactor202301\Phpactor\AmpFsWatch\WatcherConfig;
use Phpactor202301\Phpactor\AmpFsWatch\WatcherProcess;
use Phpactor202301\Psr\Log\LoggerInterface;
use Phpactor202301\Psr\Log\NullLogger;
use RuntimeException;
class FsWatchWatcher implements Watcher, WatcherProcess
{
    private const CMD = 'fswatch';
    private const POLL_TIME = 1;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var Process|null
     */
    private $process;
    /**
     * @var CommandDetector
     */
    private $commandDetector;
    /**
     * @var ModifiedFileQueue
     */
    private $queue;
    /**
     * @var bool
     */
    private $running;
    /**
     * @var WatcherConfig
     */
    private $config;
    public function __construct(WatcherConfig $config, ?LoggerInterface $logger = null, ?CommandDetector $commandDetector = null)
    {
        $this->logger = $logger ?: new NullLogger();
        $this->commandDetector = $commandDetector ?: new CommandDetector();
        $this->queue = new ModifiedFileQueue();
        $this->config = $config;
    }
    /**
     * {@inheritDoc}
     */
    public function watch() : Promise
    {
        return \Phpactor202301\Amp\call(function () {
            $this->process = (yield $this->startProcess());
            $this->running = \true;
            $this->feedQueue($this->process);
            return $this;
        });
    }
    public function wait() : Promise
    {
        return \Phpactor202301\Amp\call(function () {
            while (\false === $this->process->isRunning()) {
                (yield new Delayed(self::POLL_TIME));
            }
            while ($this->running) {
                $this->queue = $this->queue->compress();
                if ($next = $this->queue->dequeue()) {
                    return $next;
                }
                (yield new Delayed(self::POLL_TIME));
            }
            return null;
        });
    }
    public function stop() : void
    {
        if (null === $this->process) {
            throw new RuntimeException('Inotifywait process was not started, cannot call stop()');
        }
        $this->running = \false;
        $this->process->signal(\SIGTERM);
    }
    /**
     * @return Promise<Process>
     */
    private function startProcess() : Promise
    {
        return \Phpactor202301\Amp\call(function () {
            $process = new Process(\array_merge([self::CMD], $this->config->paths(), ['-r', '--event=Created', '--event=Updated', '--event=Removed']));
            $pid = (yield $process->start());
            $this->logger->debug(\sprintf('Started "%s"', $process->getCommand()));
            if (!$process->isRunning()) {
                throw new RuntimeException(\sprintf('Could not start process: %s', $process->getCommand()));
            }
            return $process;
        });
    }
    private function feedQueue(Process $process) : void
    {
        $reader = new LineReader($process->getStdout());
        \Phpactor202301\Amp\asyncCall(function () use($reader) {
            while (null !== ($line = (yield $reader->readLine()))) {
                $builder = ModifiedFileBuilder::fromPath($line);
                if (\file_exists($line) && !\is_file($line)) {
                    $builder->asFolder();
                }
                $this->queue->enqueue($builder->build());
            }
        });
    }
    public function isSupported() : Promise
    {
        return $this->commandDetector->commandExists(self::CMD);
    }
    /**
     * {@inheritDoc}
     */
    public function describe() : string
    {
        return 'fs-watch';
    }
}
\class_alias('Phpactor202301\\Phpactor\\AmpFsWatch\\Watcher\\FsWatch\\FsWatchWatcher', 'Phpactor\\AmpFsWatch\\Watcher\\FsWatch\\FsWatchWatcher', \false);