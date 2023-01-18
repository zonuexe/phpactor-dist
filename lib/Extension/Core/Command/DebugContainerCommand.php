<?php

namespace Phpactor202301\Phpactor\Extension\Core\Command;

use Phpactor202301\Phpactor\Container\Container;
use RuntimeException;
use Phpactor202301\Symfony\Component\Console\Command\Command;
use Phpactor202301\Symfony\Component\Console\Helper\Table;
use Phpactor202301\Symfony\Component\Console\Input\InputInterface;
use Phpactor202301\Symfony\Component\Console\Input\InputOption;
use Phpactor202301\Symfony\Component\Console\Output\OutputInterface;
class DebugContainerCommand extends Command
{
    public function __construct(private Container $container)
    {
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->addOption('services', null, InputOption::VALUE_NONE, 'List all services');
        $this->addOption('tags', null, InputOption::VALUE_NONE, 'List all tags');
        $this->addOption('tag', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'Show specific tag');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('services')) {
            $this->renderServices($output);
        }
        if ($input->getOption('tags')) {
            $this->renderTags($output);
        }
        foreach ((array) $input->getOption('tag') as $tag) {
            \assert(\is_string($tag));
            $this->renderTag($output, $tag);
        }
        return 0;
    }
    private function renderServices(OutputInterface $output) : Table
    {
        $table = new Table($output);
        $table->setStyle('borderless');
        $table->setHeaders(['service ID', 'class']);
        foreach ($this->container->getServiceIds() as $serviceId) {
            $type = '<not found>';
            try {
                $value = $this->container->get($serviceId);
                $type = \is_object($value) ? \get_class($value) : \gettype($value);
            } catch (RuntimeException $exception) {
                $table->addRow(['<error>Error: ' . $serviceId . '</>', $exception->getMessage()]);
            }
            $table->addRow([$serviceId, $type]);
        }
        $table->render();
        return $table;
    }
    private function renderTags(OutputInterface $output) : void
    {
        $table = new Table($output);
        $table->setStyle('borderless');
        $table->setHeaders(['tags', 'service', 'attributes']);
        foreach ($this->container->getTags() as $tag => $serviceAttributes) {
            $first = \true;
            foreach ($serviceAttributes as $serviceName => $attrs) {
                $tag = $first ? $tag : '';
                $table->addRow([$tag, $serviceName, \json_encode($attrs)]);
                $first = \false;
            }
        }
        $table->render();
    }
    private function renderTag(OutputInterface $output, string $tag) : void
    {
        $table = new Table($output);
        $table->setStyle('borderless');
        $table->setHeaders(['service', 'attributes']);
        foreach ($this->container->getServiceIdsForTag($tag) as $serviceId => $attrs) {
            $table->addRow([$serviceId, \json_encode($attrs, \JSON_PRETTY_PRINT)]);
        }
        $table->render();
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Core\\Command\\DebugContainerCommand', 'Phpactor\\Extension\\Core\\Command\\DebugContainerCommand', \false);
