<?php

namespace Phpactor202301\Phpactor\Extension\Php\Tests\Unit\Model;

use Phpactor202301\Phpactor\Extension\Php\Model\ChainResolver;
use Phpactor202301\Phpactor\Extension\Php\Model\PhpVersionResolver;
use Phpactor202301\Phpactor\TestUtils\PHPUnit\TestCase;
use RuntimeException;
class ChainResolverTest extends TestCase
{
    public function testThrowsExceptionIfNoVeresionCanBeResolved() : void
    {
        $this->expectException(RuntimeException::class);
        (new ChainResolver())->resolve();
    }
    public function testResolvesVersion() : void
    {
        $resolver = $this->prophesize(PhpVersionResolver::class);
        $resolver->resolve()->willReturn('7.1');
        self::assertEquals('7.1', (new ChainResolver($resolver->reveal()))->resolve());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Php\\Tests\\Unit\\Model\\ChainResolverTest', 'Phpactor\\Extension\\Php\\Tests\\Unit\\Model\\ChainResolverTest', \false);
