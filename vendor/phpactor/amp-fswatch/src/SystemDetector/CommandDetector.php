<?php

namespace Phpactor\AmpFsWatch\SystemDetector;

use PhpactorDist\Amp\Process\Process;
use PhpactorDist\Amp\Promise;
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
        return \PhpactorDist\Amp\call(function () use($command) {
            $process = new Process(['command', '-v', $command]);
            (yield $process->start());
            return 0 === (yield $process->join());
        });
    }
}
