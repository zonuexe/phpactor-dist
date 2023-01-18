<?php

namespace Phpactor202301\Phpactor\Indexer\Adapter\Tolerant\Indexer;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\QualifiedName;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\ClassDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\TraitUseClause;
use Phpactor202301\Phpactor\Indexer\Adapter\Tolerant\TolerantIndexer;
use Phpactor202301\Phpactor\Indexer\Model\Index;
use Phpactor202301\Phpactor\Indexer\Model\Name\FullyQualifiedName;
use Phpactor202301\Phpactor\Indexer\Model\Record\ClassRecord;
use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Patch\TolerantQualifiedNameResolver;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
class TraitUseClauseIndexer implements TolerantIndexer
{
    public function canIndex(Node $node) : bool
    {
        return $node instanceof TraitUseClause;
    }
    public function index(Index $index, TextDocument $document, Node $node) : void
    {
        \assert($node instanceof TraitUseClause);
        if (null === $node->traitNameList) {
            return;
        }
        foreach ($node->traitNameList->children as $qualifiedName) {
            if (!$qualifiedName instanceof QualifiedName) {
                continue;
            }
            $classDeclaration = $node->getFirstAncestor(ClassDeclaration::class);
            if (!$classDeclaration instanceof ClassDeclaration) {
                continue;
            }
            $traitRecord = $index->get(ClassRecord::fromName(
                // This call is a hack from WorseReflection (!) beacuse of a bug in
                // the tolerant PHP parser which does not provide the resolved
                // use namespace.
                TolerantQualifiedNameResolver::getResolvedName($qualifiedName)
            ));
            \assert($traitRecord instanceof ClassRecord);
            $traitRecord->addImplementation(FullyQualifiedName::fromString($classDeclaration->getNamespacedName()->__toString()));
            $index->write($traitRecord);
        }
    }
    public function beforeParse(Index $index, TextDocument $document) : void
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Adapter\\Tolerant\\Indexer\\TraitUseClauseIndexer', 'Phpactor\\Indexer\\Adapter\\Tolerant\\Indexer\\TraitUseClauseIndexer', \false);
