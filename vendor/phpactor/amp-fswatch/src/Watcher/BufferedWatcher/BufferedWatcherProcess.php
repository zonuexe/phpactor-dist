<?php

namespace Phpactor202301\Phpactor\AmpFsWatch\Watcher\BufferedWatcher;

use Phpactor202301\Amp\Delayed;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\AmpFsWatch\ModifiedFile;
use Phpactor202301\Phpactor\AmpFsWatch\WatcherProcess;
use Throwable;
class BufferedWatcherProcess implements WatcherProcess
{
    /**
     * @var WatcherProcess
     */
    private $innerProcess;
    /**
     * @var array<ModifiedFile>
     */
    private $buffer = [];
    /**
     * @var bool
     */
    private $running = \true;
    /**
     * @var int
     */
    private $interval;
    /**
     * @var Throwable|null
     */
    private $error;
    public function __construct(WatcherProcess $innerProcess, int $interval = 500)
    {
        $this->innerProcess = $innerProcess;
        $this->interval = $interval;
        \Phpactor202301\Amp\asyncCall(function () {
            try {
                while (null !== ($modifiedFile = (yield $this->innerProcess->wait()))) {
                    \assert($modifiedFile instanceof ModifiedFile);
                    $this->buffer[$modifiedFile->path()] = $modifiedFile;
                }
            } catch (Throwable $error) {
                $this->error = $error;
            }
            $this->running = \false;
        });
    }
    public function stop() : void
    {
        $this->running = \false;
        $this->innerProcess->stop();
    }
    /**
     * {@inheritDoc}
     */
    public function wait() : Promise
    {
        return \Phpactor202301\Amp\call(function () {
            while ($this->running || !empty($this->buffer || null !== $this->error)) {
                if ($this->error) {
                    $error = $this->error;
                    $this->error = null;
                    throw $error;
                }
                if ($this->buffer) {
                    return \array_shift($this->buffer);
                }
                (yield new Delayed($this->interval));
            }
            return null;
        });
    }
}
\class_alias('Phpactor202301\\Phpactor\\AmpFsWatch\\Watcher\\BufferedWatcher\\BufferedWatcherProcess', 'Phpactor\\AmpFsWatch\\Watcher\\BufferedWatcher\\BufferedWatcherProcess', \false);
