<?php

namespace Phpactor202301\Phpactor\Extension\Core\Command;

use Phpactor202301\Phpactor\Extension\Core\Model\JsonSchemaBuilder;
use RuntimeException;
use Phpactor202301\Symfony\Component\Console\Command\Command;
use Phpactor202301\Symfony\Component\Console\Input\InputArgument;
use Phpactor202301\Symfony\Component\Console\Input\InputInterface;
use Phpactor202301\Symfony\Component\Console\Output\OutputInterface;
class ConfigJsonSchemaCommand extends Command
{
    public function __construct(private JsonSchemaBuilder $builder)
    {
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->setDescription('Dump the JSON schema to the given relative path');
        $this->addArgument('path', InputArgument::REQUIRED, 'Target path for JSON schema file');
    }
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $path = (string) $input->getArgument('path');
        if (!@\file_put_contents($path, $this->builder->dump())) {
            throw new RuntimeException(\sprintf('Could not write JSON file "%s"', $path));
        }
        return 0;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Core\\Command\\ConfigJsonSchemaCommand', 'Phpactor\\Extension\\Core\\Command\\ConfigJsonSchemaCommand', \false);
