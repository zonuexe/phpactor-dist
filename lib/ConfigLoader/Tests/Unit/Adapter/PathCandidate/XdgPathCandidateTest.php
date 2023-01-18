<?php

namespace Phpactor202301\Phpactor\ConfigLoader\Tests\Unit\Adapter\PathCandidate;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\ConfigLoader\Adapter\PathCandidate\XdgPathCandidate;
use Phpactor202301\XdgBaseDir\Xdg;
class XdgPathCandidateTest extends TestCase
{
    public function testCandidate() : void
    {
        $candidate = new XdgPathCandidate('phpactor', 'phpactor', 'foo', new Xdg());
        $this->assertStringContainsString('phpactor', $candidate->path());
        $this->assertEquals('foo', $candidate->loader());
    }
}
\class_alias('Phpactor202301\\Phpactor\\ConfigLoader\\Tests\\Unit\\Adapter\\PathCandidate\\XdgPathCandidateTest', 'Phpactor\\ConfigLoader\\Tests\\Unit\\Adapter\\PathCandidate\\XdgPathCandidateTest', \false);
