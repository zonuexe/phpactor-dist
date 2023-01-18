<?php

namespace Phpactor202301\Phpactor\AmpFsWatch\Watcher\TestWatcher;

use Phpactor202301\Amp\Delayed;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Exception;
use Phpactor202301\Phpactor\AmpFsWatch\ModifiedFileQueue;
use Phpactor202301\Phpactor\AmpFsWatch\Watcher;
use Phpactor202301\Phpactor\AmpFsWatch\WatcherProcess;
class TestWatcher implements Watcher, WatcherProcess
{
    /**
     * @var ModifiedFileQueue
     */
    private $queue;
    /**
     * @var int
     */
    private $delay;
    /**
     * @var Exception|null
     */
    private $error;
    public function __construct(ModifiedFileQueue $queue, int $delay = 0, ?Exception $error = null)
    {
        $this->queue = $queue;
        $this->delay = $delay;
        $this->error = $error;
    }
    public function watch() : Promise
    {
        return new Success($this);
    }
    public function isSupported() : Promise
    {
        return new Success(\true);
    }
    public function stop() : void
    {
    }
    /**
     * {@inheritDoc}
     */
    public function wait() : Promise
    {
        return \Phpactor202301\Amp\call(function () {
            if ($this->delay) {
                (yield new Delayed($this->delay));
            }
            if ($this->error) {
                throw $this->error;
            }
            while (null !== ($file = $this->queue->dequeue())) {
                return $file;
            }
            return null;
        });
    }
    /**
     * {@inheritDoc}
     */
    public function describe() : string
    {
        return 'test';
    }
}
\class_alias('Phpactor202301\\Phpactor\\AmpFsWatch\\Watcher\\TestWatcher\\TestWatcher', 'Phpactor\\AmpFsWatch\\Watcher\\TestWatcher\\TestWatcher', \false);
