<?php

namespace Phpactor202301\Phpactor\Extension\Core\Console\Dumper;

use Phpactor202301\Symfony\Component\Console\Output\OutputInterface;
interface Dumper
{
    public function dump(OutputInterface $output, array $data);
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Core\\Console\\Dumper\\Dumper', 'Phpactor\\Extension\\Core\\Console\\Dumper\\Dumper', \false);
