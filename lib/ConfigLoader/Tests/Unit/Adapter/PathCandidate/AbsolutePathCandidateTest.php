<?php

namespace Phpactor202301\Phpactor\ConfigLoader\Tests\Unit\Adapter\PathCandidate;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\ConfigLoader\Adapter\PathCandidate\AbsolutePathCandidate;
use RuntimeException;
class AbsolutePathCandidateTest extends TestCase
{
    public function testExceptionifNotAbsolute() : void
    {
        $this->expectException(RuntimeException::class);
        new AbsolutePathCandidate('hello', 'foo');
    }
    public function testNormalizesWindowsPaths() : void
    {
        $path = new AbsolutePathCandidate('c:\\hello', 'foo');
        self::assertEquals('c:/hello', $path->path());
    }
}
\class_alias('Phpactor202301\\Phpactor\\ConfigLoader\\Tests\\Unit\\Adapter\\PathCandidate\\AbsolutePathCandidateTest', 'Phpactor\\ConfigLoader\\Tests\\Unit\\Adapter\\PathCandidate\\AbsolutePathCandidateTest', \false);
