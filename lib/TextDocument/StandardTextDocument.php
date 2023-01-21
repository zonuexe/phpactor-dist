<?php

namespace Phpactor\TextDocument;

class StandardTextDocument implements \Phpactor\TextDocument\TextDocument
{
    public function __construct(private \Phpactor\TextDocument\TextDocumentLanguage $language, private string $text, private ?\Phpactor\TextDocument\TextDocumentUri $uri = null)
    {
    }
    public function __toString()
    {
        return $this->text;
    }
    public function uri() : ?\Phpactor\TextDocument\TextDocumentUri
    {
        return $this->uri;
    }
    public function language() : \Phpactor\TextDocument\TextDocumentLanguage
    {
        return $this->language;
    }
}
