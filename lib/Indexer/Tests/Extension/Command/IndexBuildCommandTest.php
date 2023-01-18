<?php

namespace Phpactor202301\Phpactor\Indexer\Tests\Extension\Command;

use Phpactor202301\Phpactor\Indexer\Tests\IntegrationTestCase;
use Phpactor202301\Symfony\Component\Process\Process;
class IndexBuildCommandTest extends IntegrationTestCase
{
    public function tearDown() : void
    {
        $this->workspace()->reset();
    }
    public function testRefreshIndex() : void
    {
        $this->initProject();
        $process = new Process([__DIR__ . '/../../bin/console', 'index:build'], $this->workspace()->path());
        $process->mustRun();
        self::assertEquals(0, $process->getExitCode());
        self::assertTrue($this->workspace()->exists('cache'));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Tests\\Extension\\Command\\IndexBuildCommandTest', 'Phpactor\\Indexer\\Tests\\Extension\\Command\\IndexBuildCommandTest', \false);
