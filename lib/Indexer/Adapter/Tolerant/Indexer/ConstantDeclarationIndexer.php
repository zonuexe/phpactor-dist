<?php

namespace Phpactor202301\Phpactor\Indexer\Adapter\Tolerant\Indexer;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\ConstElement;
use Phpactor202301\Microsoft\PhpParser\Node\DelimitedList\ConstElementList;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\ArgumentExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\CallExpression;
use Phpactor202301\Microsoft\PhpParser\Node\QualifiedName;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\ConstDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\StringLiteral;
use Phpactor202301\Phpactor\Indexer\Adapter\Tolerant\TolerantIndexer;
use Phpactor202301\Phpactor\Indexer\Model\Record\ConstantRecord;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\Indexer\Model\Index;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\WorseReflection\Core\Util\NodeUtil;
class ConstantDeclarationIndexer implements TolerantIndexer
{
    public function canIndex(Node $node) : bool
    {
        if ($node instanceof ConstDeclaration) {
            return \true;
        }
        if (!$node instanceof CallExpression) {
            return \false;
        }
        /** @phpstan-ignore-next-line */
        if (!$node->callableExpression instanceof QualifiedName) {
            return \false;
        }
        /** @phpstan-ignore-next-line */
        if ('define' === NodeUtil::shortName($node->callableExpression)) {
            return \true;
        }
        return \false;
    }
    public function index(Index $index, TextDocument $document, Node $node) : void
    {
        if ($node instanceof ConstDeclaration) {
            $this->fromConstDeclaration($node, $index, $document);
            return;
        }
        if ($node instanceof CallExpression) {
            $this->fromDefine($node, $index, $document);
            return;
        }
    }
    public function beforeParse(Index $index, TextDocument $document) : void
    {
    }
    private function fromConstDeclaration(Node $node, Index $index, TextDocument $document) : void
    {
        \assert($node instanceof ConstDeclaration);
        if (!$node->constElements instanceof ConstElementList) {
            return;
        }
        foreach ($node->constElements->getChildNodes() as $constNode) {
            \assert($constNode instanceof ConstElement);
            $record = $index->get(ConstantRecord::fromName($constNode->getNamespacedName()->getFullyQualifiedNameText()));
            \assert($record instanceof ConstantRecord);
            $record->setStart(ByteOffset::fromInt($node->getStartPosition()));
            $record->setFilePath($document->uri()->path());
            $index->write($record);
        }
    }
    private function fromDefine(CallExpression $node, Index $index, TextDocument $document) : void
    {
        \assert($node instanceof CallExpression);
        if (null === $node->argumentExpressionList) {
            return;
        }
        foreach ($node->argumentExpressionList->getChildNodes() as $expression) {
            if (!$expression instanceof ArgumentExpression) {
                return;
            }
            $string = $expression->expression;
            if (!$string instanceof StringLiteral) {
                return;
            }
            $record = $index->get(ConstantRecord::fromName($string->getStringContentsText()));
            \assert($record instanceof ConstantRecord);
            $record->setStart(ByteOffset::fromInt($node->getStartPosition()));
            $record->setFilePath($document->uri()->path());
            $index->write($record);
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Adapter\\Tolerant\\Indexer\\ConstantDeclarationIndexer', 'Phpactor\\Indexer\\Adapter\\Tolerant\\Indexer\\ConstantDeclarationIndexer', \false);
