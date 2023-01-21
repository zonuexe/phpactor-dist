<?php

namespace Phpactor\Extension\Core\Console\Handler;

use Phpactor202301\Symfony\Component\Console\Command\Command;
use Phpactor202301\Symfony\Component\Console\Input\InputOption;
class FilesystemHandler
{
    public static function configure(Command $command, string $default) : void
    {
        $command->addOption('filesystem', null, InputOption::VALUE_REQUIRED, 'Filesystem (informs scope of changes)', $default);
    }
}
