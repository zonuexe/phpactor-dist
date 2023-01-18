<?php

namespace Phpactor202301\Phpactor\AmpFsWatch\Watcher\Null;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor202301\Phpactor\AmpFsWatch\WatcherProcess;
use Phpactor202301\Phpactor\AmpFsWatch\Watcher;
class NullWatcher implements Watcher, WatcherProcess
{
    /**
     * {@inheritDoc}
     */
    public function watch() : Promise
    {
        return \Phpactor202301\Amp\call(function () {
            return $this;
        });
    }
    public function isSupported() : Promise
    {
        return new Success(\true);
    }
    public function stop() : void
    {
    }
    public function wait() : Promise
    {
        return \Phpactor202301\Amp\call(function () {
            return null;
        });
    }
    /**
     * {@inheritDoc}
     */
    public function describe() : string
    {
        return 'null';
    }
}
\class_alias('Phpactor202301\\Phpactor\\AmpFsWatch\\Watcher\\Null\\NullWatcher', 'Phpactor\\AmpFsWatch\\Watcher\\Null\\NullWatcher', \false);
