<?php

declare (strict_types=1);
namespace Phpactor202301\Swoole\Server;

class TaskResult
{
    public $task_id = 0;
    public $task_worker_id = 0;
    public $dispatch_time = 0;
    public $data;
}