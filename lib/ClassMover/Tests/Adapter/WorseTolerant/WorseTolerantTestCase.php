<?php

namespace Phpactor202301\Phpactor\ClassMover\Tests\Adapter\WorseTolerant;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\ClassMover\Domain\MemberFinder;
use Phpactor202301\Phpactor\ClassMover\Adapter\WorseTolerant\WorseTolerantMemberFinder;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
abstract class WorseTolerantTestCase extends TestCase
{
    protected function createFinder(string $source) : MemberFinder
    {
        return new WorseTolerantMemberFinder(ReflectorBuilder::create()->addSource($source)->build());
    }
}
\class_alias('Phpactor202301\\Phpactor\\ClassMover\\Tests\\Adapter\\WorseTolerant\\WorseTolerantTestCase', 'Phpactor\\ClassMover\\Tests\\Adapter\\WorseTolerant\\WorseTolerantTestCase', \false);
