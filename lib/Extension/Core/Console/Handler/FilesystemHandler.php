<?php

namespace Phpactor202301\Phpactor\Extension\Core\Console\Handler;

use Phpactor202301\Symfony\Component\Console\Command\Command;
use Phpactor202301\Symfony\Component\Console\Input\InputOption;
class FilesystemHandler
{
    public static function configure(Command $command, string $default) : void
    {
        $command->addOption('filesystem', null, InputOption::VALUE_REQUIRED, 'Filesystem (informs scope of changes)', $default);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Core\\Console\\Handler\\FilesystemHandler', 'Phpactor\\Extension\\Core\\Console\\Handler\\FilesystemHandler', \false);
