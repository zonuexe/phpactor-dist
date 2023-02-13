<?php

namespace Phpactor\Extension\Debug\Command;

use Phpactor\Extension\Debug\Model\DocumentorRegistry;
use PhpactorDist\Symfony\Component\Console\Command\Command;
use PhpactorDist\Symfony\Component\Console\Input\InputInterface;
use PhpactorDist\Symfony\Component\Console\Input\InputArgument;
use PhpactorDist\Symfony\Component\Console\Output\OutputInterface;
class GenerateDocumentationCommand extends Command
{
    public function __construct(private DocumentorRegistry $documentorRegistry)
    {
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->setDescription('Generate configuration reference as an RST document');
        $this->addArgument('documentor', InputArgument::REQUIRED);
    }
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $documentor = $this->documentorRegistry->get($input->getArgument('documentor'));
        \fwrite(\STDOUT, $documentor->document($this->getName()));
        return 0;
    }
}
