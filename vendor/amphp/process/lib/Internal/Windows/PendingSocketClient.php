<?php

namespace Phpactor202301\Amp\Process\Internal\Windows;

use Phpactor202301\Amp\Struct;
/**
 * @internal
 * @codeCoverageIgnore Windows only.
 */
final class PendingSocketClient
{
    use Struct;
    public $readWatcher;
    public $timeoutWatcher;
    public $receivedDataBuffer = '';
    public $pid;
    public $streamId;
}
