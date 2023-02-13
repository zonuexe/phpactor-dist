<?php

namespace Phpactor\Extension\Core\Console\Dumper;

use PhpactorDist\Symfony\Component\Console\Output\OutputInterface;
final class JsonDumper implements \Phpactor\Extension\Core\Console\Dumper\Dumper
{
    public function dump(OutputInterface $output, array $data) : void
    {
        $output->writeln(\json_encode($data));
    }
}
