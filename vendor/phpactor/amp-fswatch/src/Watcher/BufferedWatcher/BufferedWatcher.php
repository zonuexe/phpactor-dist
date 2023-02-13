<?php

namespace Phpactor\AmpFsWatch\Watcher\BufferedWatcher;

use PhpactorDist\Amp\Promise;
use Phpactor\AmpFsWatch\Watcher;
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
        return \PhpactorDist\Amp\call(function () {
            return new \Phpactor\AmpFsWatch\Watcher\BufferedWatcher\BufferedWatcherProcess((yield $this->innerWatcher->watch()), $this->interval);
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
