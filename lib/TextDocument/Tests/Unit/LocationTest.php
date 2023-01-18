<?php

namespace Phpactor202301\Phpactor\TextDocument\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\TextDocument\Location;
class LocationTest extends TestCase
{
    public function testProvidesAccessToUri() : void
    {
        $location = Location::fromPathAndOffset('/path/to.php', 123);
        $this->assertEquals('file:///path/to.php', $location->uri()->__toString());
    }
    public function testProvidesAccessToByteOffset() : void
    {
        $location = Location::fromPathAndOffset('/path/to.php', 123);
        $this->assertEquals(123, $location->offset()->toInt());
    }
}
\class_alias('Phpactor202301\\Phpactor\\TextDocument\\Tests\\Unit\\LocationTest', 'Phpactor\\TextDocument\\Tests\\Unit\\LocationTest', \false);
