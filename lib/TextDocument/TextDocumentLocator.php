<?php

namespace Phpactor202301\Phpactor\TextDocument;

use Phpactor202301\Phpactor\TextDocument\Exception\TextDocumentNotFound;
interface TextDocumentLocator
{
    /**
     * Retrieve text document by URI
     *
     * @throws TextDocumentNotFound
     */
    public function get(TextDocumentUri $uri) : TextDocument;
}
\class_alias('Phpactor202301\\Phpactor\\TextDocument\\TextDocumentLocator', 'Phpactor\\TextDocument\\TextDocumentLocator', \false);
