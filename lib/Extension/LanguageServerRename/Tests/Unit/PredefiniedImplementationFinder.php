<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerRename\Tests\Unit;

use Phpactor202301\Phpactor\ReferenceFinder\ClassImplementationFinder;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\Locations;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
class PredefiniedImplementationFinder implements ClassImplementationFinder
{
    public function __construct(private Locations $locations)
    {
    }
    public function findImplementations(TextDocument $document, ByteOffset $byteOffset, bool $includeDefinition = \false) : Locations
    {
        return $this->locations;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerRename\\Tests\\Unit\\PredefiniedImplementationFinder', 'Phpactor\\Extension\\LanguageServerRename\\Tests\\Unit\\PredefiniedImplementationFinder', \false);
