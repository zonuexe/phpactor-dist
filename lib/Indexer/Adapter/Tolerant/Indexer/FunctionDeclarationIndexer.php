<?php

namespace Phpactor202301\Phpactor\Indexer\Adapter\Tolerant\Indexer;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\FunctionDeclaration;
use Phpactor202301\Phpactor\Indexer\Adapter\Tolerant\TolerantIndexer;
use Phpactor202301\Phpactor\Indexer\Model\Index;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\Indexer\Model\Record\FunctionRecord;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
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
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Adapter\\Tolerant\\Indexer\\FunctionDeclarationIndexer', 'Phpactor\\Indexer\\Adapter\\Tolerant\\Indexer\\FunctionDeclarationIndexer', \false);
