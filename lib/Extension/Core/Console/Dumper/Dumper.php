<?php

namespace Phpactor\Extension\Core\Console\Dumper;

use Phpactor202301\Symfony\Component\Console\Output\OutputInterface;
interface Dumper
{
    public function dump(OutputInterface $output, array $data);
}
