<?php

namespace Phpactor\Indexer\Adapter\Tolerant\Indexer;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\TraitDeclaration;
use Phpactor\Indexer\Model\Index;
use Phpactor\Indexer\Model\Record\ClassRecord;
use Phpactor\TextDocument\TextDocument;
class TraitDeclarationIndexer extends \Phpactor\Indexer\Adapter\Tolerant\Indexer\AbstractClassLikeIndexer
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
