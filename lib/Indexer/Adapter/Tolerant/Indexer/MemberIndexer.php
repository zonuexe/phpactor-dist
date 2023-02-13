<?php

namespace Phpactor\Indexer\Adapter\Tolerant\Indexer;

use PhpactorDist\Microsoft\PhpParser\Node;
use PhpactorDist\Microsoft\PhpParser\Node\Expression\CallExpression;
use PhpactorDist\Microsoft\PhpParser\Node\Expression\MemberAccessExpression;
use PhpactorDist\Microsoft\PhpParser\Node\Expression\ScopedPropertyAccessExpression;
use PhpactorDist\Microsoft\PhpParser\Node\Expression\Variable;
use PhpactorDist\Microsoft\PhpParser\Node\QualifiedName;
use PhpactorDist\Microsoft\PhpParser\Node\TraitSelectOrAliasClause;
use PhpactorDist\Microsoft\PhpParser\Token;
use Phpactor\Indexer\Adapter\Tolerant\TolerantIndexer;
use Phpactor\Indexer\Model\Index;
use Phpactor\Indexer\Model\MemberReference;
use Phpactor\Indexer\Model\RecordReference;
use Phpactor\Indexer\Model\Record\FileRecord;
use Phpactor\Indexer\Model\Record\MemberRecord;
use Phpactor\TextDocument\TextDocument;
class MemberIndexer implements TolerantIndexer
{
    public function canIndex(Node $node) : bool
    {
        return $node instanceof TraitSelectOrAliasClause || $node instanceof ScopedPropertyAccessExpression || $node instanceof MemberAccessExpression;
    }
    public function beforeParse(Index $index, TextDocument $document) : void
    {
        $fileRecord = $index->get(FileRecord::fromPath($document->uri()->path()));
        \assert($fileRecord instanceof FileRecord);
        foreach ($fileRecord->references() as $outgoingReference) {
            if ($outgoingReference->type() !== MemberRecord::RECORD_TYPE) {
                continue;
            }
            $memberRecord = $index->get(MemberRecord::fromIdentifier($outgoingReference->identifier()));
            \assert($memberRecord instanceof MemberRecord);
            $memberRecord->removeReference($fileRecord->identifier());
            $index->write($memberRecord);
            $fileRecord->removeReferencesToRecordType($outgoingReference->type());
            $index->write($fileRecord);
        }
    }
    public function index(Index $index, TextDocument $document, Node $node) : void
    {
        if ($node instanceof TraitSelectOrAliasClause) {
            $this->indexTraitSelectOrAliasClause($index, $document, $node);
            return;
        }
        if ($node instanceof ScopedPropertyAccessExpression) {
            $this->indexScopedPropertyAccess($index, $document, $node);
            return;
        }
        if ($node instanceof MemberAccessExpression) {
            $this->indexMemberAccessExpression($index, $document, $node);
            return;
        }
    }
    /**
     * @param MemberRecord::TYPE_* $memberType
     */
    private function indexScopedPropertyAccess(Index $index, TextDocument $document, ScopedPropertyAccessExpression $node, ?string $memberType = null) : void
    {
        $containerType = $node->scopeResolutionQualifier;
        if (!$containerType instanceof QualifiedName) {
            return;
        }
        $containerType = $this->resolveContainerType($containerType, $node);
        $memberName = $this->resolveScopedPropertyAccessName($node);
        if (empty($memberName)) {
            return;
        }
        $memberType = $memberType ?? $this->resolveScopedPropertyAccessMemberType($node);
        $this->writeIndex($index, $memberType, $containerType, $memberName, $document, $this->resolveStart($node->memberName));
    }
    /**
     * @return MemberRecord::TYPE_*
     */
    private function resolveScopedPropertyAccessMemberType(ScopedPropertyAccessExpression $node) : string
    {
        if ($node->parent instanceof CallExpression) {
            return MemberRecord::TYPE_METHOD;
        }
        if ($node->memberName instanceof Variable) {
            return MemberRecord::TYPE_PROPERTY;
        }
        return MemberRecord::TYPE_CONSTANT;
    }
    /**
     * @return MemberRecord::TYPE_METHOD|MemberRecord::TYPE_PROPERTY
     */
    private function resolveMemberAccessType(MemberAccessExpression $node) : string
    {
        if ($node->parent instanceof CallExpression) {
            return MemberRecord::TYPE_METHOD;
        }
        return MemberRecord::TYPE_PROPERTY;
    }
    private function resolveScopedPropertyAccessName(ScopedPropertyAccessExpression $node) : string
    {
        $memberName = $node->memberName;
        if ($memberName instanceof Token) {
            return (string) $memberName->getText($node->getFileContents());
        }
        if (!$memberName instanceof Variable) {
            return '';
        }
        return (string) $memberName->getName();
    }
    private function indexMemberAccessExpression(Index $index, TextDocument $document, MemberAccessExpression $node) : void
    {
        $memberName = $node->memberName;
        /** @phpstan-ignore-next-line Member name could be NULL */
        if (null === $memberName) {
            return;
        }
        if (!$memberName instanceof Token) {
            return;
        }
        $memberName = $memberName->getText($node->getFileContents());
        if (empty($memberName)) {
            return;
        }
        $memberType = $this->resolveMemberAccessType($node);
        $this->writeIndex($index, $memberType, null, (string) $memberName, $document, $this->resolveStart($node->memberName));
    }
    /**
     * @param MemberRecord::TYPE_* $memberType
     */
    private function writeIndex(Index $index, string $memberType, ?string $containerFqn, string $memberName, TextDocument $document, int $offsetStart) : void
    {
        $record = $index->get(MemberRecord::fromMemberReference(MemberReference::create($memberType, $containerFqn, $memberName)));
        \assert($record instanceof MemberRecord);
        $record->addReference($document->uri()->path());
        $index->write($record);
        $fileRecord = $index->get(FileRecord::fromPath($document->uri()->path()));
        \assert($fileRecord instanceof FileRecord);
        $fileRecord->addReference(RecordReference::fromRecordAndOffsetAndContainerType($record, $offsetStart, $containerFqn));
        $index->write($fileRecord);
    }
    /**
     * @param Token|Node $nodeOrToken
     */
    private function resolveStart($nodeOrToken) : int
    {
        if ($nodeOrToken instanceof Token) {
            return $nodeOrToken->start;
        }
        return $nodeOrToken->getStartPosition();
    }
    private function resolveContainerType(QualifiedName $containerType, Node $node) : ?string
    {
        $containerType = (string) $containerType->getResolvedName();
        // let static analysis solve these later - we cannot determine the
        // correct values efficiently now (traits etc).
        if (\in_array($containerType, ['self', 'static', 'parent'])) {
            return null;
        }
        return $containerType;
    }
    private function indexTraitSelectOrAliasClause(Index $index, TextDocument $document, TraitSelectOrAliasClause $node) : void
    {
        if ($node->name instanceof ScopedPropertyAccessExpression) {
            $this->indexScopedPropertyAccess($index, $document, $node->name, MemberRecord::TYPE_METHOD);
        }
    }
}
