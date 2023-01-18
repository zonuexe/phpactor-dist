<?php

namespace Phpactor202301\Phpactor\Indexer\Adapter\Tolerant\Indexer;

use Phpactor202301\Microsoft\PhpParser\NamespacedNameInterface;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\QualifiedName;
use Phpactor202301\Microsoft\PhpParser\Node\DelimitedList\QualifiedNameList;
use Phpactor202301\Phpactor\Indexer\Adapter\Tolerant\TolerantIndexer;
use Phpactor202301\Phpactor\Indexer\Model\Exception\CannotIndexNode;
use Phpactor202301\Phpactor\Indexer\Model\Name\FullyQualifiedName;
use Phpactor202301\Phpactor\Indexer\Model\Record\ClassRecord;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\Indexer\Model\Index;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
abstract class AbstractClassLikeIndexer implements TolerantIndexer
{
    public function beforeParse(Index $index, TextDocument $document) : void
    {
    }
    protected function removeImplementations(Index $index, ClassRecord $record) : void
    {
        foreach ($record->implements() as $implementedClass) {
            $implementedRecord = $index->get(ClassRecord::fromName($implementedClass));
            if (\false === $implementedRecord->removeImplementation($record->fqn())) {
                continue;
            }
            $index->write($implementedRecord);
        }
    }
    protected function indexInterfaceList(QualifiedNameList $interfaceList, ClassRecord $record, Index $index) : void
    {
        foreach ($interfaceList->children as $interfaceName) {
            if (!$interfaceName instanceof QualifiedName) {
                continue;
            }
            $interfaceName = $interfaceName->getResolvedName();
            $interfaceRecord = $index->get(ClassRecord::fromName($interfaceName));
            $record->addImplements(FullyQualifiedName::fromString($interfaceName));
            \assert($interfaceRecord instanceof ClassRecord);
            $interfaceRecord->addImplementation($record->fqn());
            $index->write($interfaceRecord);
        }
    }
    /**
     * @param ClassRecord::TYPE_* $type
     */
    protected function getClassLikeRecord(string $type, Node $node, Index $index, TextDocument $document) : ClassRecord
    {
        \assert($node instanceof NamespacedNameInterface);
        $name = $node->getNamespacedName()->getFullyQualifiedNameText();
        if (empty($name)) {
            throw new CannotIndexNode(\sprintf('Name is empty for file "%s"', $document->uri()->path()));
        }
        $record = $index->get(ClassRecord::fromName($name));
        \assert($record instanceof ClassRecord);
        $record->setStart(ByteOffset::fromInt($node->getStartPosition()));
        $record->setFilePath($document->uri()->path());
        $record->setType($type);
        return $record;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Adapter\\Tolerant\\Indexer\\AbstractClassLikeIndexer', 'Phpactor\\Indexer\\Adapter\\Tolerant\\Indexer\\AbstractClassLikeIndexer', \false);
