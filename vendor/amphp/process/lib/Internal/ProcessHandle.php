<?php

namespace PhpactorDist\Amp\Process\Internal;

use PhpactorDist\Amp\Deferred;
use PhpactorDist\Amp\Process\ProcessInputStream;
use PhpactorDist\Amp\Process\ProcessOutputStream;
use PhpactorDist\Amp\Struct;
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
