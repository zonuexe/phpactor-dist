<?php

namespace Phpactor202301\Phpactor\Indexer\Tests\Adapter;

use Phpactor202301\Phpactor\Indexer\Tests\IntegrationTestCase;
use function Phpactor202301\Safe\file_get_contents;
abstract class IndexTestCase extends IntegrationTestCase
{
    protected function setUp() : void
    {
        $this->workspace()->reset();
        $this->workspace()->loadManifest(file_get_contents(__DIR__ . '/Manifest/buildIndex.php.test'));
    }
    public function testBuild() : void
    {
        $agent = $this->indexAgent();
        $agent->indexer()->getJob()->run();
        $references = $foo = $agent->query()->class()->implementing('Index');
        self::assertCount(2, $references);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Tests\\Adapter\\IndexTestCase', 'Phpactor\\Indexer\\Tests\\Adapter\\IndexTestCase', \false);
