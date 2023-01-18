<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerIndexer\Tests\Extension;

use Phpactor202301\Phpactor\AmpFsWatch\Exception\WatcherDied;
use Phpactor202301\Phpactor\AmpFsWatch\ModifiedFileQueue;
use Phpactor202301\Phpactor\AmpFsWatch\Watcher\TestWatcher\TestWatcher;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Indexer\Extension\IndexerExtension;
use Phpactor202301\Phpactor\MapResolver\Resolver;
class TestExtension implements Extension
{
    public function load(ContainerBuilder $container) : void
    {
        $container->register('test.watcher.will_die', function (Container $container) {
            return new TestWatcher(new ModifiedFileQueue(), 0, new WatcherDied('No'));
        }, [IndexerExtension::TAG_WATCHER => ['name' => 'will_die']]);
    }
    public function configure(Resolver $schema) : void
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerIndexer\\Tests\\Extension\\TestExtension', 'Phpactor\\Extension\\LanguageServerIndexer\\Tests\\Extension\\TestExtension', \false);
