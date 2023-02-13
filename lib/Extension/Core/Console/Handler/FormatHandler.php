<?php

namespace Phpactor\Extension\Core\Console\Handler;

use PhpactorDist\Symfony\Component\Console\Command\Command;
use PhpactorDist\Symfony\Component\Console\Input\InputOption;
class FormatHandler
{
    public static function configure(Command $command) : void
    {
        $command->addOption('format', null, InputOption::VALUE_REQUIRED, 'Output format');
    }
}
