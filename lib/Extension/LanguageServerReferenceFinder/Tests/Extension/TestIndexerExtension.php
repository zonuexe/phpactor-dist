<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerReferenceFinder\Tests\Extension;

use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Indexer\IndexAgentBuilder;
use Phpactor202301\Phpactor\Indexer\Model\Indexer;
use Phpactor202301\Phpactor\MapResolver\Resolver;
class TestIndexerExtension implements Extension
{
    public function load(ContainerBuilder $container) : void
    {
        $container->register(Indexer::class, function () {
            return IndexAgentBuilder::create(__DIR__ . '/../Workspace', __DIR__ . '/../Workspace')->buildTestAgent()->indexer();
        });
    }
    public function configure(Resolver $schema) : void
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerReferenceFinder\\Tests\\Extension\\TestIndexerExtension', 'Phpactor\\Extension\\LanguageServerReferenceFinder\\Tests\\Extension\\TestIndexerExtension', \false);
