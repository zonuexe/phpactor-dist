<?php

namespace Phpactor\Indexer\Adapter\Tolerant\Indexer;

use PhpactorDist\Microsoft\PhpParser\Node;
use PhpactorDist\Microsoft\PhpParser\Node\Statement\FunctionDeclaration;
use Phpactor\Indexer\Adapter\Tolerant\TolerantIndexer;
use Phpactor\Indexer\Model\Index;
use Phpactor\TextDocument\ByteOffset;
use Phpactor\Indexer\Model\Record\FunctionRecord;
use Phpactor\TextDocument\TextDocument;
class FunctionDeclarationIndexer implements TolerantIndexer
{
    public function canIndex(Node $node) : bool
    {
        return $node instanceof FunctionDeclaration;
    }
    public function index(Index $index, TextDocument $document, Node $node) : void
    {
        \assert($node instanceof FunctionDeclaration);
        $record = $index->get(FunctionRecord::fromName($node->getNamespacedName()->getFullyQualifiedNameText()));
        \assert($record instanceof FunctionRecord);
        $record->setStart(ByteOffset::fromInt($node->getStartPosition()));
        $record->setFilePath($document->uri()->path());
        $index->write($record);
    }
    public function beforeParse(Index $index, TextDocument $document) : void
    {
    }
}
