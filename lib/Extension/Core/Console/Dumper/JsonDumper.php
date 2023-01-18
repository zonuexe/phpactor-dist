<?php

namespace Phpactor202301\Phpactor\Extension\Core\Console\Dumper;

use Phpactor202301\Symfony\Component\Console\Output\OutputInterface;
final class JsonDumper implements Dumper
{
    public function dump(OutputInterface $output, array $data) : void
    {
        $output->writeln(\json_encode($data));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Core\\Console\\Dumper\\JsonDumper', 'Phpactor\\Extension\\Core\\Console\\Dumper\\JsonDumper', \false);
