<?php

namespace Phpactor202301\Phpactor\WorseReferenceFinder\Tests;

use Phpactor202301\Phpactor\ReferenceFinder\DefinitionLocator;
use Phpactor202301\Phpactor\ReferenceFinder\TypeLocations;
use Phpactor202301\Phpactor\TestUtils\ExtractOffset;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
abstract class DefinitionLocatorTestCase extends IntegrationTestCase
{
    protected function locate(string $manifset, string $source) : TypeLocations
    {
        [$source, $offset] = ExtractOffset::fromSource($source);
        $documentUri = $this->workspace->path('somefile.php');
        $this->workspace->loadManifest($manifset);
        return $this->locator()->locateDefinition(TextDocumentBuilder::create($source)->uri($documentUri)->language('php')->build(), ByteOffset::fromInt((int) $offset));
    }
    protected abstract function locator() : DefinitionLocator;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReferenceFinder\\Tests\\DefinitionLocatorTestCase', 'Phpactor\\WorseReferenceFinder\\Tests\\DefinitionLocatorTestCase', \false);
