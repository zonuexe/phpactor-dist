<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerBridge\TextDocument;

use Phpactor202301\Phpactor\TextDocument\Exception\TextDocumentNotFound;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
use Phpactor202301\Phpactor\TextDocument\TextDocumentLocator;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
class FilesystemWorkspaceLocator implements TextDocumentLocator
{
    public function get(TextDocumentUri $uri) : TextDocument
    {
        if (!\file_exists($uri->path())) {
            throw TextDocumentNotFound::fromUri($uri);
        }
        return TextDocumentBuilder::fromUri($uri->__toString())->build();
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerBridge\\TextDocument\\FilesystemWorkspaceLocator', 'Phpactor\\Extension\\LanguageServerBridge\\TextDocument\\FilesystemWorkspaceLocator', \false);
