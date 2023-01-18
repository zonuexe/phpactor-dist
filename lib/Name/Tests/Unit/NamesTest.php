<?php

namespace Phpactor202301\Phpactor\Name\Tests\Unit;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Name\Names;
use Phpactor202301\Phpactor\Name\QualifiedName;
class NamesTest extends TestCase
{
    public function testCreateFromArray() : void
    {
        $names = Names::fromNames([QualifiedName::fromString('Hello'), QualifiedName::fromString('Goodbye')]);
        self::assertCount(2, $names);
    }
    public function testCanIterate() : void
    {
        $names = Names::fromNames([QualifiedName::fromString('Hello'), QualifiedName::fromString('Goodbye')]);
        self::assertIsIterable($names);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Name\\Tests\\Unit\\NamesTest', 'Phpactor\\Name\\Tests\\Unit\\NamesTest', \false);
