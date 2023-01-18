<?php

namespace Phpactor202301\Phpactor\TextDocument\TextDocumentLocator;

use Phpactor202301\Phpactor\TextDocument\Exception\TextDocumentNotFound;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use Phpactor202301\Phpactor\TextDocument\TextDocumentLocator;
class ChainDocumentLocator implements TextDocumentLocator
{
    /**
     * @param TextDocumentLocator[] $locators
     */
    public function __construct(private array $locators)
    {
    }
    public function get(TextDocumentUri $uri) : TextDocument
    {
        foreach ($this->locators as $workspace) {
            try {
                return $workspace->get($uri);
            } catch (TextDocumentNotFound) {
            }
        }
        throw TextDocumentNotFound::fromUri($uri);
    }
}
\class_alias('Phpactor202301\\Phpactor\\TextDocument\\TextDocumentLocator\\ChainDocumentLocator', 'Phpactor\\TextDocument\\TextDocumentLocator\\ChainDocumentLocator', \false);
