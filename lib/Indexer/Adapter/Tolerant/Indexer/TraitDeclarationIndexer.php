<?php

namespace Phpactor\Indexer\Adapter\Tolerant\Indexer;

use PhpactorDist\Microsoft\PhpParser\MissingToken;
use PhpactorDist\Microsoft\PhpParser\Node;
use PhpactorDist\Microsoft\PhpParser\Node\Statement\TraitDeclaration;
use Phpactor\Indexer\Model\Exception\CannotIndexNode;
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
        if ($node->name instanceof MissingToken) {
            throw new CannotIndexNode(\sprintf('Class name is missing (maybe a reserved word) in: %s', $document->uri()?->path() ?? '?'));
        }
        $record = $this->getClassLikeRecord(ClassRecord::TYPE_TRAIT, $node, $index, $document);
        $index->write($record);
    }
}
