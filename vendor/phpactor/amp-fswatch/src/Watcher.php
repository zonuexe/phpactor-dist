<?php

namespace Phpactor\AmpFsWatch;

use Phpactor202301\Amp\Promise;
interface Watcher
{
    /**
     * @return Promise<WatcherProcess>
     */
    public function watch() : Promise;
    /**
     * @return Promise<bool>
     */
    public function isSupported() : Promise;
    /**
     * @return string
     */
    public function describe() : string;
}
