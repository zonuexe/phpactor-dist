<?php

namespace Phpactor202301\Phpactor\Extension\WorseReflectionExtra\Command;

use Phpactor202301\Symfony\Component\Console\Command\Command;
use Phpactor202301\Symfony\Component\Console\Input\InputInterface;
use Phpactor202301\Symfony\Component\Console\Output\OutputInterface;
use Phpactor202301\Symfony\Component\Console\Input\InputArgument;
use Phpactor202301\Symfony\Component\Console\Input\InputOption;
use Phpactor202301\Phpactor\Extension\WorseReflectionExtra\Application\OffsetInfo;
use Phpactor202301\Phpactor\Extension\Core\Console\Dumper\DumperRegistry;
use Phpactor202301\Phpactor\Extension\Core\Console\Handler\FormatHandler;
class OffsetInfoCommand extends Command
{
    public function __construct(private OffsetInfo $infoForOffset, private DumperRegistry $dumperRegistry)
    {
        parent::__construct();
    }
    public function configure() : void
    {
        $this->setDescription('Return information about given file at the given offset');
        $this->addArgument('path', InputArgument::REQUIRED, 'Source path or FQN');
        $this->addArgument('offset', InputArgument::REQUIRED, 'Destination path or FQN');
        $this->addOption('frame', null, InputOption::VALUE_NONE, 'Show inferred frame state at offset');
        FormatHandler::configure($this);
    }
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $info = $this->infoForOffset->infoForOffset($input->getArgument('path'), $input->getArgument('offset'), $input->getOption('frame'));
        $format = $input->getOption('format');
        $this->dumperRegistry->get($format)->dump($output, $info);
        return 0;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\WorseReflectionExtra\\Command\\OffsetInfoCommand', 'Phpactor\\Extension\\WorseReflectionExtra\\Command\\OffsetInfoCommand', \false);