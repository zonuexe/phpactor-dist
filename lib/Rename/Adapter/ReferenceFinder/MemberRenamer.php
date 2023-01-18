<?php

namespace Phpactor202301\Phpactor\Rename\Adapter\ReferenceFinder;

use Generator;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\ClassConstDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\ConstElement;
use Phpactor202301\Microsoft\PhpParser\Node\EnumCaseDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\MemberAccessExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\ScopedPropertyAccessExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\Variable;
use Phpactor202301\Microsoft\PhpParser\Node\MethodDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\Parameter;
use Phpactor202301\Microsoft\PhpParser\Node\PropertyDeclaration;
use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\Phpactor\ReferenceFinder\ClassImplementationFinder;
use Phpactor202301\Phpactor\ReferenceFinder\ReferenceFinder;
use Phpactor202301\Phpactor\Rename\Model\LocatedTextEdit;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\ByteOffsetRange;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\TextDocument\TextDocumentLocator;
class MemberRenamer extends AbstractReferenceRenamer
{
    public function __construct(ReferenceFinder $referenceFinder, TextDocumentLocator $locator, Parser $parser, private ClassImplementationFinder $implementationFinder)
    {
        parent::__construct($referenceFinder, $locator, $parser);
    }
    public function getRenameRangeForNode(Node $node) : ?ByteOffsetRange
    {
        if ($node instanceof MethodDeclaration) {
            return ByteOffsetRange::fromInts($node->name->start, $node->name->getEndPosition());
        }
        // hack because the WR property deefinition locator returns the
        // property declaration and not the variable
        if ($node instanceof PropertyDeclaration) {
            $variable = $node->getFirstDescendantNode(Variable::class);
            if (!$variable instanceof Variable) {
                return null;
            }
            return $this->offsetRangeFromToken($variable->name, \true);
        }
        if ($node instanceof Parameter) {
            if ($node->visibilityToken === null) {
                return null;
            }
            return $this->offsetRangeFromToken($node->variableName, \true);
        }
        // hack because the WR property deefinition locator returns the
        // property declaration and not the variable
        if ($node instanceof ClassConstDeclaration) {
            $constElement = $node->getFirstDescendantNode(ConstElement::class);
            if (!$constElement instanceof ConstElement) {
                return null;
            }
            return $this->offsetRangeFromToken($constElement->name, \false);
        }
        if ($node instanceof EnumCaseDeclaration) {
            return $this->offsetRangeFromToken($node->name, \false);
        }
        if ($node instanceof Variable && $node->getFirstAncestor(PropertyDeclaration::class)) {
            return $this->offsetRangeFromToken($node->name, \true);
        }
        if ($node instanceof Variable && ($node->getFirstAncestor(ScopedPropertyAccessExpression::class) || $node->getFirstAncestor(MemberAccessExpression::class))) {
            return $this->offsetRangeFromToken($node->name, \true);
        }
        if ($node instanceof MemberAccessExpression || $node instanceof ScopedPropertyAccessExpression) {
            return $this->offsetRangeFromToken($node->memberName, \false);
        }
        if ($node instanceof ConstElement) {
            return ByteOffsetRange::fromInts($node->name->start, $node->name->getEndPosition());
        }
        return null;
    }
    /**
     * @return Generator<LocatedTextEdit>
     */
    protected function doRename(TextDocument $textDocument, ByteOffset $offset, ByteOffsetRange $range, string $originalName, string $newName) : Generator
    {
        foreach ($this->implementationFinder->findImplementations($textDocument, $offset, \true) as $location) {
            (yield $this->renameEdit($location, $range, $originalName, $newName));
        }
        yield from parent::doRename($textDocument, $offset, $range, $originalName, $newName);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Rename\\Adapter\\ReferenceFinder\\MemberRenamer', 'Phpactor\\Rename\\Adapter\\ReferenceFinder\\MemberRenamer', \false);
