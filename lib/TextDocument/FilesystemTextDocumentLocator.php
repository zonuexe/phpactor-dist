<?php

namespace Phpactor\TextDocument;

use Phpactor\TextDocument\Exception\TextDocumentNotFound;
class FilesystemTextDocumentLocator implements \Phpactor\TextDocument\TextDocumentLocator
{
    public function get(\Phpactor\TextDocument\TextDocumentUri $uri) : \Phpactor\TextDocument\TextDocument
    {
        if (!\file_exists($uri->path())) {
            throw TextDocumentNotFound::fromUri($uri);
        }
        return \Phpactor\TextDocument\TextDocumentBuilder::fromUri($uri->__toString())->build();
    }
}
