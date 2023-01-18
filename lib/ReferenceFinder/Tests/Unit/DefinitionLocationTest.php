<?php

namespace Phpactor202301\Phpactor\ReferenceFinder\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\ReferenceFinder\DefinitionLocation;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
class DefinitionLocationTest extends TestCase
{
    const EXAMPLE_URI = '/path/to.php';
    const EXAMPLE_OFFSET = 1234;
    public function testValues() : void
    {
        $location = new DefinitionLocation(TextDocumentUri::fromString(self::EXAMPLE_URI), ByteOffset::fromInt(self::EXAMPLE_OFFSET));
        $this->assertEquals(self::EXAMPLE_URI, $location->uri()->path());
        $this->assertEquals(self::EXAMPLE_OFFSET, $location->offset()->toInt());
    }
}
\class_alias('Phpactor202301\\Phpactor\\ReferenceFinder\\Tests\\Unit\\DefinitionLocationTest', 'Phpactor\\ReferenceFinder\\Tests\\Unit\\DefinitionLocationTest', \false);
