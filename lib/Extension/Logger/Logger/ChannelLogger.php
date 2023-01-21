<?php

namespace Phpactor\Extension\Logger\Logger;

use Phpactor202301\Psr\Log\AbstractLogger;
use Phpactor202301\Psr\Log\LoggerInterface;
class ChannelLogger extends AbstractLogger
{
    public function __construct(private string $name, private LoggerInterface $innerLogger)
    {
    }
    public function log($level, $message, array $context = []) : void
    {
        $this->innerLogger->log($level, $message, \array_merge(['channel' => $this->name], $context));
    }
}
