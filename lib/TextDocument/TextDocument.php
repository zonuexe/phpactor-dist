<?php

namespace Phpactor\TextDocument;

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
    public function uri() : ?\Phpactor\TextDocument\TextDocumentUri;
    /**
     * Return language value object for the text document.
     */
    public function language() : \Phpactor\TextDocument\TextDocumentLanguage;
    public function uriOrThrow() : \Phpactor\TextDocument\TextDocumentUri;
}
