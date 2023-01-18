<?php

namespace Phpactor202301\Phpactor\Indexer\Adapter\Tolerant\Indexer;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\TraitDeclaration;
use Phpactor202301\Phpactor\Indexer\Model\Index;
use Phpactor202301\Phpactor\Indexer\Model\Record\ClassRecord;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
class TraitDeclarationIndexer extends AbstractClassLikeIndexer
{
    public function canIndex(Node $node) : bool
    {
        return $node instanceof TraitDeclaration;
    }
    public function index(Index $index, TextDocument $document, Node $node) : void
    {
        \assert($node instanceof TraitDeclaration);
        $record = $this->getClassLikeRecord(ClassRecord::TYPE_TRAIT, $node, $index, $document);
        $index->write($record);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Adapter\\Tolerant\\Indexer\\TraitDeclarationIndexer', 'Phpactor\\Indexer\\Adapter\\Tolerant\\Indexer\\TraitDeclarationIndexer', \false);
