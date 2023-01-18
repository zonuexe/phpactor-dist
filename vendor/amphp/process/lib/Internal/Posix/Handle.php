<?php

namespace Phpactor202301\Amp\Process\Internal\Posix;

use Phpactor202301\Amp\Deferred;
use Phpactor202301\Amp\Loop;
use Phpactor202301\Amp\Process\Internal\ProcessHandle;
/** @internal */
final class Handle extends ProcessHandle
{
    public function __construct()
    {
        $this->pidDeferred = new Deferred();
        $this->joinDeferred = new Deferred();
        $this->originalParentPid = \getmypid();
    }
    /** @var Deferred */
    public $joinDeferred;
    /** @var resource */
    public $proc;
    /** @var resource */
    public $extraDataPipe;
    /** @var string */
    public $extraDataPipeWatcher;
    /** @var string */
    public $extraDataPipeStartWatcher;
    /** @var int */
    public $originalParentPid;
    /** @var int */
    public $shellPid;
    public function wait()
    {
        if ($this->shellPid === 0) {
            return;
        }
        $pid = $this->shellPid;
        $this->shellPid = 0;
        Loop::unreference(Loop::repeat(100, static function (string $watcherId) use($pid) {
            if (!\extension_loaded('pcntl') || \pcntl_waitpid($pid, $status, \WNOHANG) !== 0) {
                Loop::cancel($watcherId);
            }
        }));
    }
    public function __destruct()
    {
        $this->wait();
    }
}
