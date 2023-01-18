<?php

namespace Phpactor202301\Phpactor\Extension\Logger;

use Phpactor202301\Phpactor\Extension\Logger\Logger\ChannelLogger;
use Phpactor202301\Psr\Log\LoggerInterface;
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
\class_alias('Phpactor202301\\Phpactor\\Extension\\Logger\\LoggerFactory', 'Phpactor\\Extension\\Logger\\LoggerFactory', \false);
