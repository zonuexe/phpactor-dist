<?php

namespace Phpactor\Extension\Core\Console\Dumper;

use PhpactorDist\Symfony\Component\Console\Output\OutputInterface;
interface Dumper
{
    public function dump(OutputInterface $output, array $data);
}
