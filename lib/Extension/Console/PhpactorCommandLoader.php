<?php

namespace Phpactor202301\Phpactor\Extension\Console;

use Phpactor202301\Symfony\Component\Console\CommandLoader\ContainerCommandLoader;
class PhpactorCommandLoader extends ContainerCommandLoader
{
    public function get(string $name)
    {
        $command = parent::get($name);
        $command->setName($name);
        return $command;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Console\\PhpactorCommandLoader', 'Phpactor\\Extension\\Console\\PhpactorCommandLoader', \false);
