<?php

namespace Phpactor202301\Phpactor\AmpFsWatch\Watcher\BufferedWatcher;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\AmpFsWatch\Watcher;
class BufferedWatcher implements Watcher
{
    /**
     * @var Watcher
     */
    private $innerWatcher;
    /**
     * @var int
     */
    private $interval;
    public function __construct(Watcher $innerWatcher, int $interval)
    {
        $this->innerWatcher = $innerWatcher;
        $this->interval = $interval;
    }
    public function watch() : Promise
    {
        return \Phpactor202301\Amp\call(function () {
            return new BufferedWatcherProcess((yield $this->innerWatcher->watch()), $this->interval);
        });
    }
    /**
     * {@inheritDoc}
     */
    public function isSupported() : Promise
    {
        return $this->innerWatcher->isSupported();
    }
    /**
     * {@inheritDoc}
     */
    public function describe() : string
    {
        return \sprintf('buffered %s', $this->innerWatcher->describe());
    }
}
\class_alias('Phpactor202301\\Phpactor\\AmpFsWatch\\Watcher\\BufferedWatcher\\BufferedWatcher', 'Phpactor\\AmpFsWatch\\Watcher\\BufferedWatcher\\BufferedWatcher', \false);
