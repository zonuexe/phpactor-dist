<?php

namespace Phpactor202301\Phpactor\Extension\SourceCodeFilesystemExtra\Command;

use Phpactor202301\Phpactor\Extension\SourceCodeFilesystem\SourceCodeFilesystemExtension;
use Phpactor202301\Symfony\Component\Console\Command\Command;
use Phpactor202301\Symfony\Component\Console\Input\InputInterface;
use Phpactor202301\Symfony\Component\Console\Output\OutputInterface;
use Phpactor202301\Symfony\Component\Console\Input\InputArgument;
use Phpactor202301\Phpactor\Extension\SourceCodeFilesystemExtra\SourceCodeFilestem\Application\ClassSearch;
use Phpactor202301\Phpactor\Extension\Core\Console\Dumper\DumperRegistry;
use Phpactor202301\Phpactor\Extension\Core\Console\Handler\FormatHandler;
use Phpactor202301\Phpactor\Extension\Core\Console\Handler\FilesystemHandler;
class ClassSearchCommand extends Command
{
    public function __construct(private ClassSearch $search, private DumperRegistry $dumperRegistry)
    {
        parent::__construct();
    }
    public function configure() : void
    {
        $this->setDescription('Search for class by (short) name and return informations on candidates');
        $this->addArgument('name', InputArgument::REQUIRED, 'Source path or FQN');
        FormatHandler::configure($this);
        FilesystemHandler::configure($this, SourceCodeFilesystemExtension::FILESYSTEM_COMPOSER);
    }
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $results = $this->search->classSearch($input->getOption('filesystem'), $input->getArgument('name'));
        $dumper = $this->dumperRegistry->get($input->getOption('format'));
        $dumper->dump($output, $results);
        return 0;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\SourceCodeFilesystemExtra\\Command\\ClassSearchCommand', 'Phpactor\\Extension\\SourceCodeFilesystemExtra\\Command\\ClassSearchCommand', \false);