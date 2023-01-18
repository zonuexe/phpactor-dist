<?php

namespace Phpactor202301\Phpactor\Extension\WorseReflectionExtra\Command;

use Phpactor202301\Symfony\Component\Console\Command\Command;
use Phpactor202301\Symfony\Component\Console\Input\InputInterface;
use Phpactor202301\Symfony\Component\Console\Output\OutputInterface;
use Phpactor202301\Phpactor\Extension\WorseReflectionExtra\Application\ClassReflector;
use Phpactor202301\Symfony\Component\Console\Input\InputArgument;
use Phpactor202301\Phpactor\Extension\Core\Console\Dumper\DumperRegistry;
use Phpactor202301\Phpactor\Extension\Core\Console\Handler\FormatHandler;
class ClassReflectorCommand extends Command
{
    public function __construct(private ClassReflector $reflector, private DumperRegistry $dumperRegistry)
    {
        parent::__construct();
    }
    public function configure() : void
    {
        $this->setDescription('Reflect a given class (path or FQN)');
        $this->addArgument('name', InputArgument::REQUIRED, 'Source path or FQN');
        FormatHandler::configure($this);
    }
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $reflection = $this->reflector->reflect($input->getArgument('name'));
        $this->dumperRegistry->get($input->getOption('format'))->dump($output, $reflection);
        return 0;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\WorseReflectionExtra\\Command\\ClassReflectorCommand', 'Phpactor\\Extension\\WorseReflectionExtra\\Command\\ClassReflectorCommand', \false);
