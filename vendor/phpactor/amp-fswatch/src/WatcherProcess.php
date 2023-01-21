<?php

namespace Phpactor\AmpFsWatch;

use Phpactor202301\Amp\Promise;
interface WatcherProcess
{
    public function stop() : void;
    /**
     * @return Promise<?ModifiedFile>
     */
    public function wait() : Promise;
}
