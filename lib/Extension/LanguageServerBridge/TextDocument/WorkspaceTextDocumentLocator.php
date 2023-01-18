<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerBridge\TextDocument;

use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\TextDocumentConverter;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Exception\UnknownDocument;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace as PhpactorWorkspace;
use Phpactor202301\Phpactor\TextDocument\Exception\TextDocumentNotFound;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\TextDocument\TextDocumentLocator;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
class WorkspaceTextDocumentLocator implements TextDocumentLocator
{
    public function __construct(private PhpactorWorkspace $workspace)
    {
    }
    public function get(TextDocumentUri $uri) : TextDocument
    {
        try {
            return TextDocumentConverter::fromLspTextItem($this->workspace->get($uri->__toString()));
        } catch (UnknownDocument) {
        }
        throw TextDocumentNotFound::fromUri($uri);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerBridge\\TextDocument\\WorkspaceTextDocumentLocator', 'Phpactor\\Extension\\LanguageServerBridge\\TextDocument\\WorkspaceTextDocumentLocator', \false);
