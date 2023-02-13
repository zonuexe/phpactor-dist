<?php

namespace Phpactor\Extension\Logger;

use Phpactor\Extension\Logger\Logger\ChannelLogger;
use PhpactorDist\Psr\Log\LoggerInterface;
class LoggerFactory
{
    public function __construct(private LoggerInterface $mainLogger)
    {
    }
    public function get(string $name) : LoggerInterface
    {
        return new ChannelLogger($name, $this->mainLogger);
    }
}
