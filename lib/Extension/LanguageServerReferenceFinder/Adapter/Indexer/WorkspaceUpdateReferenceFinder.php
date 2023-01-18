<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerReferenceFinder\Adapter\Indexer;

use Generator;
use Phpactor202301\Phpactor\Indexer\Model\Indexer;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
use Phpactor202301\Phpactor\ReferenceFinder\ReferenceFinder;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\Exception\TextDocumentNotFound;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
class WorkspaceUpdateReferenceFinder implements ReferenceFinder
{
    public function __construct(private Workspace $workspace, private Indexer $indexer, private ReferenceFinder $innerReferenceFinder)
    {
    }
    public function findReferences(TextDocument $document, ByteOffset $byteOffset) : Generator
    {
        $this->indexWorkspace();
        yield from $this->innerReferenceFinder->findReferences($document, $byteOffset);
    }
    private function indexWorkspace() : void
    {
        // ensure that the index is current with the workspace
        foreach ($this->workspace as $document) {
            \assert($document instanceof TextDocumentItem);
            try {
                $this->indexer->indexDirty(TextDocumentBuilder::fromUri($document->uri)->text($document->text)->build());
            } catch (TextDocumentNotFound) {
            }
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerReferenceFinder\\Adapter\\Indexer\\WorkspaceUpdateReferenceFinder', 'Phpactor\\Extension\\LanguageServerReferenceFinder\\Adapter\\Indexer\\WorkspaceUpdateReferenceFinder', \false);
