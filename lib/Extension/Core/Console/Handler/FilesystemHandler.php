<?php

namespace Phpactor\Extension\Core\Console\Handler;

use PhpactorDist\Symfony\Component\Console\Command\Command;
use PhpactorDist\Symfony\Component\Console\Input\InputOption;
class FilesystemHandler
{
    public static function configure(Command $command, string $default) : void
    {
        $command->addOption('filesystem', null, InputOption::VALUE_REQUIRED, 'Filesystem (informs scope of changes)', $default);
    }
}
