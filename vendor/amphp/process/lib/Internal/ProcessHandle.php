<?php

namespace Phpactor202301\Amp\Process\Internal;

use Phpactor202301\Amp\Deferred;
use Phpactor202301\Amp\Process\ProcessInputStream;
use Phpactor202301\Amp\Process\ProcessOutputStream;
use Phpactor202301\Amp\Struct;
abstract class ProcessHandle
{
    use Struct;
    /** @var ProcessOutputStream */
    public $stdin;
    /** @var ProcessInputStream */
    public $stdout;
    /** @var ProcessInputStream */
    public $stderr;
    /** @var Deferred */
    public $pidDeferred;
    /** @var int */
    public $status = ProcessStatus::STARTING;
}
