<?php

namespace Phpactor202301\Phpactor\Extension\ReferenceFinder\Tests\Example;

use Phpactor202301\Phpactor\ReferenceFinder\ClassImplementationFinder;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\Locations;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
class SomeImplementationFinder implements ClassImplementationFinder
{
    public function findImplementations(TextDocument $document, ByteOffset $byteOffset, bool $includeDefinition = \false) : Locations
    {
        return new Locations([]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\ReferenceFinder\\Tests\\Example\\SomeImplementationFinder', 'Phpactor\\Extension\\ReferenceFinder\\Tests\\Example\\SomeImplementationFinder', \false);
