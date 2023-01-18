<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerRename\Tests\Extension;

use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Extension\LanguageServerRename\LanguageServerRenameExtension;
use Phpactor202301\Phpactor\Rename\Model\FileRenamer;
use Phpactor202301\Phpactor\Rename\Model\FileRenamer\TestFileRenamer;
use Phpactor202301\Phpactor\Rename\Model\Renamer\InMemoryRenamer;
use Phpactor202301\Phpactor\MapResolver\Resolver;
use Phpactor202301\Phpactor\TextDocument\ByteOffsetRange;
class TestExtension implements Extension
{
    public function load(ContainerBuilder $container) : void
    {
        $container->register(InMemoryRenamer::class, function (Container $container) {
            return new InMemoryRenamer($container->getParameter('range'), $container->getParameter('results'));
        }, [LanguageServerRenameExtension::TAG_RENAMER => []]);
        $container->register(FileRenamer::class, function (Container $container) {
            return new TestFileRenamer();
        }, []);
    }
    public function configure(Resolver $schema) : void
    {
        $schema->setDefaults(['range' => ByteOffsetRange::fromInts(0, 10), 'results' => []]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerRename\\Tests\\Extension\\TestExtension', 'Phpactor\\Extension\\LanguageServerRename\\Tests\\Extension\\TestExtension', \false);
