<?php

namespace Phpactor202301\Phpactor\FilePathResolver\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\FilePathResolver\LoggingPathResolver;
use Phpactor202301\Phpactor\FilePathResolver\PathResolver;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use Phpactor202301\Psr\Log\LoggerInterface;
class LoggingPathResolverTest extends TestCase
{
    use ProphecyTrait;
    public function testLogsResolvedPath() : void
    {
        $innerResolver = $this->prophesize(PathResolver::class);
        $logger = $this->prophesize(LoggerInterface::class);
        $innerResolver->resolve('foo')->willReturn('bar');
        $resolver = new LoggingPathResolver($innerResolver->reveal(), $logger->reveal());
        $this->assertEquals('bar', $resolver->resolve('foo'));
        $logger->log('debug', 'Resolved path "foo" to "bar"')->shouldHaveBeenCalled();
    }
}
\class_alias('Phpactor202301\\Phpactor\\FilePathResolver\\Tests\\Unit\\LoggingPathResolverTest', 'Phpactor\\FilePathResolver\\Tests\\Unit\\LoggingPathResolverTest', \false);
