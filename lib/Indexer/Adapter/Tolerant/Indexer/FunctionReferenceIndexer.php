<?php

namespace Phpactor202301\Phpactor\Indexer\Adapter\Tolerant\Indexer;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\CallExpression;
use Phpactor202301\Microsoft\PhpParser\Node\QualifiedName;
use Phpactor202301\Phpactor\Indexer\Model\Index;
use Phpactor202301\Phpactor\Indexer\Model\RecordReference;
use Phpactor202301\Phpactor\Indexer\Model\Record\FileRecord;
use Phpactor202301\Phpactor\Indexer\Model\Record\FunctionRecord;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
class FunctionReferenceIndexer extends AbstractClassLikeIndexer
{
    public function canIndex(Node $node) : bool
    {
        return $node instanceof QualifiedName && $node->parent instanceof CallExpression;
    }
    public function beforeParse(Index $index, TextDocument $document) : void
    {
        $fileRecord = $index->get(FileRecord::fromPath($document->uri()->path()));
        \assert($fileRecord instanceof FileRecord);
        foreach ($fileRecord->references() as $outgoingReference) {
            if ($outgoingReference->type() !== FunctionRecord::RECORD_TYPE) {
                continue;
            }
            $record = $index->get(FunctionRecord::fromName($outgoingReference->identifier()));
            \assert($record instanceof FunctionRecord);
            $record->removeReference($fileRecord->identifier());
            $index->write($record);
        }
    }
    public function index(Index $index, TextDocument $document, Node $node) : void
    {
        \assert($node instanceof QualifiedName);
        // this is slow
        $name = $node->getResolvedName() ? $node->getResolvedName() : null;
        if (null === $name) {
            $name = (string) $node;
        }
        $targetRecord = $index->get(FunctionRecord::fromName($name));
        \assert($targetRecord instanceof FunctionRecord);
        $targetRecord->addReference($document->uri()->path());
        $index->write($targetRecord);
        $fileRecord = $index->get(FileRecord::fromPath($document->uri()->path()));
        \assert($fileRecord instanceof FileRecord);
        $fileRecord->addReference(new RecordReference(FunctionRecord::RECORD_TYPE, $targetRecord->identifier(), $node->getStartPosition()));
        $index->write($fileRecord);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Adapter\\Tolerant\\Indexer\\FunctionReferenceIndexer', 'Phpactor\\Indexer\\Adapter\\Tolerant\\Indexer\\FunctionReferenceIndexer', \false);
