<?php

namespace Phpactor202301\Phpactor\Indexer\Adapter\Tolerant\Indexer;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\EnumDeclaration;
use Phpactor202301\Phpactor\Indexer\Model\Record\ClassRecord;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\Indexer\Model\Index;
class EnumDeclarationIndexer extends AbstractClassLikeIndexer
{
    public function canIndex(Node $node) : bool
    {
        return $node instanceof EnumDeclaration;
    }
    public function index(Index $index, TextDocument $document, Node $node) : void
    {
        \assert($node instanceof EnumDeclaration);
        $record = $this->getClassLikeRecord(ClassRecord::TYPE_ENUM, $node, $index, $document);
        $this->removeImplementations($index, $record);
        $record->clearImplemented();
        $index->write($record);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Adapter\\Tolerant\\Indexer\\EnumDeclarationIndexer', 'Phpactor\\Indexer\\Adapter\\Tolerant\\Indexer\\EnumDeclarationIndexer', \false);
