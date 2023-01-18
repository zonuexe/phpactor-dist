<?php

namespace Phpactor202301\Phpactor\Rename\Tests\Adapter\ReferenceFinder;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\ReferenceFinder\ReferenceFinder;
use Phpactor202301\Phpactor\ReferenceFinder\PotentialLocation;
use Phpactor202301\Phpactor\Rename\Model\ReferenceFinder\PredefinedReferenceFinder;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\Location;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
abstract class ReferenceRenamerIntegrationTestCase extends TestCase
{
    /**
     * @param ByteOffset[] $references
     */
    public function offsetsToReferenceFinder(TextDocument $textDocument, array $references) : ReferenceFinder
    {
        return new PredefinedReferenceFinder(...\array_map(function (ByteOffset $reference) use($textDocument) {
            return PotentialLocation::surely(new Location($textDocument->uri(), $reference));
        }, $references));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Rename\\Tests\\Adapter\\ReferenceFinder\\ReferenceRenamerIntegrationTestCase', 'Phpactor\\Rename\\Tests\\Adapter\\ReferenceFinder\\ReferenceRenamerIntegrationTestCase', \false);
