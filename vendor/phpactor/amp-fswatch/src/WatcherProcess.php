<?php

namespace Phpactor202301\Phpactor\AmpFsWatch;

use Phpactor202301\Amp\Promise;
interface WatcherProcess
{
    public function stop() : void;
    /**
     * @return Promise<?ModifiedFile>
     */
    public function wait() : Promise;
}
\class_alias('Phpactor202301\\Phpactor\\AmpFsWatch\\WatcherProcess', 'Phpactor\\AmpFsWatch\\WatcherProcess', \false);
