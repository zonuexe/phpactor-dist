<?php

namespace Phpactor202301\Phpactor\TextDocument;

/**
 * Represents source code or other text documents.
 */
interface TextDocument
{
    /**
     * Return the document as a string
     */
    public function __toString();
    /**
     * Return the URI to the document or NULL if the document has not been
     * persisted yet.
     */
    public function uri() : ?TextDocumentUri;
    /**
     * Return language value object for the text document.
     */
    public function language() : TextDocumentLanguage;
}
/**
 * Represents source code or other text documents.
 */
\class_alias('Phpactor202301\\Phpactor\\TextDocument\\TextDocument', 'Phpactor\\TextDocument\\TextDocument', \false);
