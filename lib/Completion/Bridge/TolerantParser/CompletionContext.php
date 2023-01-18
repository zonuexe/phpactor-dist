<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\TolerantParser;

use Phpactor202301\Microsoft\PhpParser\ClassLike;
use Phpactor202301\Microsoft\PhpParser\MissingToken;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\ArrayElement;
use Phpactor202301\Microsoft\PhpParser\Node\Attribute;
use Phpactor202301\Microsoft\PhpParser\Node\AttributeGroup;
use Phpactor202301\Microsoft\PhpParser\Node\ClassBaseClause;
use Phpactor202301\Microsoft\PhpParser\Node\ClassInterfaceClause;
use Phpactor202301\Microsoft\PhpParser\Node\ClassMembersNode;
use Phpactor202301\Microsoft\PhpParser\Node\ConstElement;
use Phpactor202301\Microsoft\PhpParser\Node\DelimitedList\QualifiedNameList;
use Phpactor202301\Microsoft\PhpParser\Node\Expression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\AnonymousFunctionCreationExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\Variable;
use Phpactor202301\Microsoft\PhpParser\Node\InterfaceBaseClause;
use Phpactor202301\Microsoft\PhpParser\Node\MethodDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\NamespaceUseClause;
use Phpactor202301\Microsoft\PhpParser\Node\Parameter;
use Phpactor202301\Microsoft\PhpParser\Node\QualifiedName as MicrosoftQualifiedName;
use Phpactor202301\Microsoft\PhpParser\Node\SourceFileNode;
use Phpactor202301\Microsoft\PhpParser\Node\StatementNode;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\ClassDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\CompoundStatementNode;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\EnumDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\InterfaceDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\TraitDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\TraitUseClause;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\WorseReflection\Core\Util\NodeUtil;
class CompletionContext
{
    public static function expression(?Node $node) : bool
    {
        if (null === $node) {
            return \false;
        }
        $parent = $node->parent;
        if (null === $parent) {
            return \false;
        }
        if (self::classMembersBody($node)) {
            return \false;
        }
        return $parent instanceof Expression || $parent instanceof StatementNode || $parent instanceof ConstElement || $parent instanceof ArrayElement;
    }
    public static function attribute(?Node $node) : bool
    {
        if (null === $node) {
            return \false;
        }
        return $node instanceof AttributeGroup || $node instanceof Attribute || $node->parent instanceof Attribute;
    }
    public static function useImport(?Node $node) : bool
    {
        if (null === $node) {
            return \false;
        }
        return $node->parent instanceof NamespaceUseClause;
    }
    public static function classLike(?Node $node) : bool
    {
        if (null === $node) {
            return \false;
        }
        $parent = $node->parent;
        if (null === $parent) {
            return \false;
        }
        if ($parent->parent) {
            if (self::isClassClause($parent->parent)) {
                return \true;
            }
        }
        return self::isClassClause($parent);
    }
    public static function type(?Node $node) : bool
    {
        if (null === $node) {
            return \false;
        }
        if (null === $node->parent) {
            return \false;
        }
        // no type-completion clauses (extends, implements, use)
        // as these are class-like only
        if ($node->parent->parent) {
            if (self::isClassClause($node->parent->parent)) {
                return \false;
            }
        }
        if ($node->parent instanceof Parameter || $node->parent instanceof QualifiedNameList) {
            return \true;
        }
        return \false;
    }
    public static function nodeOrParentIs(?Node $node, string $type) : bool
    {
        if (null === $node) {
            return \false;
        }
        if ($node instanceof $type) {
            return \true;
        }
        if ($node->parent instanceof $type) {
            return \true;
        }
        return \false;
    }
    public static function classMembersBody(?Node $node) : bool
    {
        if (null === $node) {
            return \false;
        }
        if ($node instanceof ClassMembersNode) {
            return \true;
        }
        if (null === $node->parent) {
            return \false;
        }
        if ($node->parent instanceof ConstElement) {
            return \false;
        }
        $nodeBeforeOffset = NodeUtil::firstDescendantNodeBeforeOffset($node->getRoot(), $node->parent->getStartPosition());
        if ($node instanceof Variable) {
            return \false;
        }
        if ($nodeBeforeOffset instanceof ClassMembersNode) {
            return \true;
        }
        $classLike = $nodeBeforeOffset->getFirstAncestor(ClassLike::class);
        if (!$classLike) {
            return \false;
        }
        if ($classLike->getEndPosition() < $node->getStartPosition()) {
            if ($classLike instanceof ClassDeclaration) {
                if (!$classLike->classMembers->closeBrace instanceof MissingToken) {
                    return \false;
                }
            }
            if ($classLike instanceof InterfaceDeclaration) {
                if (!$classLike->interfaceMembers->closeBrace instanceof MissingToken) {
                    return \false;
                }
            }
            if ($classLike instanceof TraitDeclaration) {
                if (!$classLike->traitMembers->closeBrace instanceof MissingToken) {
                    return \false;
                }
            }
            if ($classLike instanceof EnumDeclaration) {
                if (!$classLike->enumMembers->closeBrace instanceof MissingToken) {
                    return \false;
                }
            }
        }
        if ($nodeBeforeOffset instanceof CompoundStatementNode && $node->getStartPosition() < $nodeBeforeOffset->getEndPosition()) {
            return \false;
        }
        $memberDeclaration = $nodeBeforeOffset->getFirstAncestor(MethodDeclaration::class, ConstElement::class);
        if (!$memberDeclaration) {
            return \true;
        }
        if ($memberDeclaration->getEndPosition() < $node->getStartPosition()) {
            return \true;
        }
        return \false;
    }
    public static function classClause(?Node $node, ByteOffset $offset) : bool
    {
        if (null === $node) {
            return \false;
        }
        $prefix = \substr($node->getFileContents(), 0, $offset->toInt());
        if (\preg_match('{(class|interface|trait)\\s+[^\\s]+\\s*[^\\s\\{]*$}', $prefix)) {
            return \true;
        }
        if (\preg_match('{(class|interface|trait)\\s+[^\\s]+\\s*(implements|extends)\\s+([^,\\s\\{]+[,\\s]*)*$}', $prefix)) {
            return \true;
        }
        return \false;
    }
    public static function anonymousUse(Node $node) : bool
    {
        if (!$node->parent) {
            return \false;
        }
        $compound = $node->parent->parent;
        if (!$compound instanceof CompoundStatementNode) {
            return \false;
        }
        $anonymous = $compound->parent;
        if (!$anonymous instanceof AnonymousFunctionCreationExpression) {
            return \false;
        }
        if (!$compound->openBrace instanceof MissingToken) {
            return \false;
        }
        if (!$anonymous->anonymousFunctionUseClause) {
            return \false;
        }
        return \true;
    }
    public static function methodName(Node $node) : bool
    {
        return $node->parent instanceof MethodDeclaration;
    }
    public static function declaration(Node $node, ByteOffset $offset) : bool
    {
        if (!$node->parent) {
            return \false;
        }
        if (!$node->parent->parent) {
            return \false;
        }
        if (!$node instanceof MicrosoftQualifiedName) {
            return \false;
        }
        if (!$node->parent->parent instanceof SourceFileNode) {
            return \false;
        }
        if ($node->parent->getText() !== $node->getText()) {
            return \false;
        }
        $previous = NodeUtil::previousSibling($node->parent);
        // for some reason `class Foobar { func<>` will result in `func` being an sibling to `class Foobar` instead of
        // within the members node.
        // To fix this ensure that if the previous is a declaration then make sure that it doesn't have a missing closed token
        if ($previous instanceof ClassDeclaration) {
            if ($previous->classMembers->closeBrace instanceof MissingToken) {
                return \false;
            }
        }
        if ($previous instanceof TraitDeclaration) {
            if ($previous->traitMembers->closeBrace instanceof MissingToken) {
                return \false;
            }
        }
        if ($previous instanceof InterfaceDeclaration) {
            if ($previous->interfaceMembers->closeBrace instanceof MissingToken) {
                return \false;
            }
        }
        if ($previous instanceof EnumDeclaration) {
            if ($previous->enumMembers->closeBrace instanceof MissingToken) {
                return \false;
            }
        }
        if ($node->getEndPosition() < $previous->getEndPosition()) {
            return \false;
        }
        return \true;
    }
    private static function isClassClause(?Node $node) : bool
    {
        if (null === $node) {
            return \false;
        }
        return $node instanceof InterfaceBaseClause || $node instanceof ClassInterfaceClause || $node instanceof TraitUseClause || $node instanceof ClassBaseClause;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\TolerantParser\\CompletionContext', 'Phpactor\\Completion\\Bridge\\TolerantParser\\CompletionContext', \false);
