<?php

namespace Phpactor202301\Phpactor\AmpFsWatch\SystemDetector;

use Phpactor202301\Amp\Process\Process;
use Phpactor202301\Amp\Promise;
class CommandDetector
{
    /**
     * @return Promise<bool>
     */
    public function commandExists(string $command) : Promise
    {
        return $this->checkPosixCommand($command);
    }
    /**
     * @return Promise<bool>
     */
    private function checkPosixCommand(string $command) : Promise
    {
        return \Phpactor202301\Amp\call(function () use($command) {
            $process = new Process(['command', '-v', $command]);
            (yield $process->start());
            return 0 === (yield $process->join());
        });
    }
}
\class_alias('Phpactor202301\\Phpactor\\AmpFsWatch\\SystemDetector\\CommandDetector', 'Phpactor\\AmpFsWatch\\SystemDetector\\CommandDetector', \false);
