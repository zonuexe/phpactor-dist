<?php

namespace Phpactor202301\Phpactor\Extension\ClassToFileExtra\Command;

use Phpactor202301\Symfony\Component\Console\Command\Command;
use Phpactor202301\Symfony\Component\Console\Input\InputInterface;
use Phpactor202301\Symfony\Component\Console\Output\OutputInterface;
use Phpactor202301\Symfony\Component\Console\Input\InputArgument;
use Phpactor202301\Phpactor\Extension\Core\Console\Dumper\DumperRegistry;
use Phpactor202301\Phpactor\Extension\Core\Console\Handler\FormatHandler;
use Phpactor202301\Phpactor\Extension\ClassToFileExtra\Application\FileInfo;
class FileInfoCommand extends Command
{
    public function __construct(private FileInfo $infoForOffset, private DumperRegistry $dumperRegistry)
    {
        parent::__construct();
    }
    public function configure() : void
    {
        $this->setDescription('Return information about given file');
        $this->addArgument('path', InputArgument::REQUIRED, 'Source path or FQN');
        FormatHandler::configure($this);
    }
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $info = $this->infoForOffset->infoForFile($input->getArgument('path'));
        $format = $input->getOption('format');
        $this->dumperRegistry->get($format)->dump($output, $info);
        return 0;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\ClassToFileExtra\\Command\\FileInfoCommand', 'Phpactor\\Extension\\ClassToFileExtra\\Command\\FileInfoCommand', \false);
