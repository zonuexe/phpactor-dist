<?php

namespace Phpactor\Extension\Core\Command;

use Phpactor202301\Symfony\Component\Console\Command\Command;
use Phpactor202301\Symfony\Component\Console\Input\InputInterface;
use Phpactor202301\Symfony\Component\Console\Output\OutputInterface;
use Phpactor\Extension\Core\Application\CacheClear;
class CacheClearCommand extends Command
{
    public function __construct(private CacheClear $cache)
    {
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->setDescription('Clear the cache');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->cache->clearCache();
        $output->writeln(\sprintf('<info>Cache cleared: </>%s', $this->cache->cachePath()));
        return 0;
    }
}
