<?php

namespace Phpactor202301\Phpactor\ClassMover\Tests\Unit\Domain\Name;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\ClassMover\Domain\Name\MemberName;
class MemberNameTest extends TestCase
{
    public function testValidName() : void
    {
        $name = MemberName::fromString('foobar');
        $this->assertEquals('foobar', (string) $name);
    }
    public function testCompareDollars() : void
    {
        $name = MemberName::fromString('$foobar');
        $this->assertTrue($name->matches('foobar'));
        $this->assertTrue($name->matches('$foobar'));
        $name = MemberName::fromString('foobar');
        $this->assertTrue($name->matches('$foobar'));
        $name = MemberName::fromString('foobar');
        $this->assertTrue($name->matches('foobar'));
    }
}
\class_alias('Phpactor202301\\Phpactor\\ClassMover\\Tests\\Unit\\Domain\\Name\\MemberNameTest', 'Phpactor\\ClassMover\\Tests\\Unit\\Domain\\Name\\MemberNameTest', \false);
