<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerReferenceFinder\Model;

use Generator;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\ConstElement;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\AssignmentExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\CallExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\MemberAccessExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\ScopedPropertyAccessExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\Variable;
use Phpactor202301\Microsoft\PhpParser\Node\MethodDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\Parameter;
use Phpactor202301\Microsoft\PhpParser\Node\PropertyDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\QualifiedName;
use Phpactor202301\Microsoft\PhpParser\Node\SourceFileNode;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\ClassDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\NamespaceUseClause;
use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\Microsoft\PhpParser\Token;
use Phpactor202301\Phpactor\LanguageServerProtocol\DocumentHighlight;
use Phpactor202301\Phpactor\LanguageServerProtocol\DocumentHighlightKind;
use Phpactor202301\Phpactor\LanguageServerProtocol\Position;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\EfficientLineCols;
class Highlighter
{
    public function __construct(private Parser $parser)
    {
    }
    public function highlightsFor(string $source, ByteOffset $offset) : Highlights
    {
        $offsets = [];
        $highlights = [];
        foreach ($this->generate($source, $offset) as $highlight) {
            $offsets[] = $highlight->start;
            $offsets[] = $highlight->end;
            $highlights[] = $highlight;
        }
        $lineCols = EfficientLineCols::fromByteOffsetInts($source, $offsets, \true);
        $lspHighlights = [];
        foreach ($highlights as $highlight) {
            $startPos = $lineCols->get($highlight->start);
            $endPos = $lineCols->get($highlight->end);
            $lspHighlights[] = new DocumentHighlight(new Range(new Position($startPos->line() - 1, $startPos->col() - 1), new Position($endPos->line() - 1, $endPos->col() - 1)), $highlight->kind);
        }
        return new Highlights(...$lspHighlights);
    }
    /**
     * @return Generator<Highlight>
     */
    public function generate(string $source, ByteOffset $offset) : Generator
    {
        $rootNode = $this->parser->parseSourceFile($source);
        $node = $rootNode->getDescendantNodeAtPosition($offset->toInt());
        if ($node instanceof Variable && $node->getFirstAncestor(PropertyDeclaration::class)) {
            yield from $this->properties($rootNode, (string) $node->getName());
            return;
        }
        if ($node instanceof Parameter) {
            yield from null === $node->visibilityToken ? $this->variables($rootNode, (string) $node->getName()) : $this->properties($rootNode, (string) $node->getName());
            return;
        }
        if ($node instanceof Variable) {
            yield from $this->variables($rootNode, (string) $node->getName());
            return;
        }
        if ($node instanceof MethodDeclaration) {
            yield from $this->methods($rootNode, $node->getName());
            return;
        }
        if ($node instanceof ClassDeclaration) {
            yield from $this->namespacedNames($rootNode, (string) $node->getNamespacedName());
            return;
        }
        if ($node instanceof ConstElement) {
            yield from $this->constants($rootNode, (string) $node->getNamespacedName());
            return;
        }
        if ($node instanceof QualifiedName) {
            yield from $this->namespacedNames($rootNode, (string) $node->getResolvedName() ?: (string) $node->getNamespacedName());
            return;
        }
        if ($node instanceof ScopedPropertyAccessExpression) {
            $memberName = $node->memberName;
            if (!$memberName instanceof Token) {
                return;
            }
            yield from $this->memberAccess($rootNode, $node, (string) $memberName->getText($rootNode->getFileContents()));
            return;
        }
        if ($node instanceof MemberAccessExpression) {
            yield from $this->memberAccess($rootNode, $node, (string) $node->memberName->getText($rootNode->getFileContents()));
            return;
        }
        return;
    }
    /**
     * @return Generator<Highlight>
     */
    private function variables(SourceFileNode $rootNode, string $name) : Generator
    {
        $name = $this->normalizeVarName($name);
        foreach ($rootNode->getDescendantNodes() as $childNode) {
            if ($childNode instanceof Variable && $childNode->getName() === $name) {
                (yield new Highlight($childNode->getStartPosition(), $childNode->getEndPosition(), $this->variableKind($childNode)));
            }
            if ($childNode instanceof Parameter && $this->normalizeVarName((string) $childNode->variableName->getText($childNode->getFileContents())) === $name) {
                (yield new Highlight($childNode->variableName->getStartPosition(), $childNode->variableName->getEndPosition(), DocumentHighlightKind::READ));
            }
        }
    }
    /**
     * @return DocumentHighlightKind::*
     * @phpstan-ignore-next-line
     */
    private function variableKind(Node $node) : int
    {
        $expression = $node->parent;
        if ($expression instanceof AssignmentExpression) {
            if ($expression->leftOperand === $node) {
                return DocumentHighlightKind::WRITE;
            }
        }
        return DocumentHighlightKind::READ;
    }
    /**
     * @return Generator<Highlight>
     */
    private function properties(Node $rootNode, string $name) : Generator
    {
        foreach ($rootNode->getDescendantNodes() as $node) {
            if ($node instanceof Parameter && null !== $node->visibilityToken && (string) $node->getName() === $name) {
                (yield new Highlight($node->variableName->getStartPosition(), $node->variableName->getEndPosition(), DocumentHighlightKind::TEXT));
                continue;
            }
            if ($node instanceof Variable && $node->getFirstAncestor(PropertyDeclaration::class) && (string) $node->getName() === $name) {
                (yield new Highlight($node->getStartPosition(), $node->getEndPosition(), DocumentHighlightKind::TEXT));
            }
            if ($node instanceof MemberAccessExpression) {
                if ($name === $node->memberName->getText($rootNode->getFileContents())) {
                    (yield new Highlight($node->memberName->getStartPosition(), $node->memberName->getEndPosition(), $this->variableKind($node)));
                }
            }
        }
    }
    /**
     * @return Generator<Highlight>
     */
    private function memberAccess(SourceFileNode $rootNode, Node $node, string $memberName) : Generator
    {
        if ($node->parent instanceof CallExpression) {
            return yield from $this->methods($rootNode, $memberName);
        }
        if (\str_contains($node->getText(), '$')) {
            return yield from $this->properties($rootNode, $memberName);
        }
        return yield from $this->constants($rootNode, $memberName);
    }
    /**
     * @return Generator<Highlight>
     */
    private function methods(SourceFileNode $rootNode, string $name) : Generator
    {
        foreach ($rootNode->getDescendantNodes() as $node) {
            if ($node instanceof MethodDeclaration && $node->getName() === $name) {
                (yield new Highlight($node->name->getStartPosition(), $node->name->getEndPosition(), DocumentHighlightKind::TEXT));
            }
            if ($node instanceof MemberAccessExpression) {
                if ($name === $node->memberName->getText($rootNode->getFileContents())) {
                    (yield new Highlight($node->memberName->getStartPosition(), $node->memberName->getEndPosition(), $this->variableKind($node)));
                }
            }
            if ($node instanceof ScopedPropertyAccessExpression) {
                $memberName = $node->memberName;
                if (!$memberName instanceof Token) {
                    return;
                }
                if ($name === $memberName->getText($rootNode->getFileContents())) {
                    (yield new Highlight($memberName->getStartPosition(), $memberName->getEndPosition(), $this->variableKind($node)));
                }
            }
        }
    }
    /**
     * @return Generator<Highlight>
     */
    private function constants(SourceFileNode $rootNode, string $name) : Generator
    {
        foreach ($rootNode->getDescendantNodes() as $node) {
            if ($node instanceof ConstElement && (string) $node->getNamespacedName() === $name) {
                (yield new Highlight($node->name->getStartPosition(), $node->name->getEndPosition(), DocumentHighlightKind::TEXT));
            }
            if ($node instanceof ScopedPropertyAccessExpression) {
                $memberName = $node->memberName;
                if (!$memberName instanceof Token) {
                    return;
                }
                if ($name === $memberName->getText($rootNode->getFileContents())) {
                    (yield new Highlight($memberName->getStartPosition(), $memberName->getEndPosition(), $this->variableKind($node)));
                }
            }
        }
    }
    /**
     * @return Generator<Highlight>
     */
    private function namespacedNames(Node $rootNode, string $fullyQualfiedName) : Generator
    {
        foreach ($rootNode->getDescendantNodes() as $node) {
            if ($node instanceof NamespaceUseClause && (string) $node->namespaceName === $fullyQualfiedName) {
                $nameParts = $node->namespaceName->nameParts;
                $name = \end($nameParts);
                (yield new Highlight($name->getStartPosition(), $name->getEndPosition(), DocumentHighlightKind::TEXT));
            }
            if ($node instanceof ClassDeclaration && (string) $node->getNamespacedName() === $fullyQualfiedName) {
                (yield new Highlight($node->name->getStartPosition(), $node->name->getEndPosition(), DocumentHighlightKind::TEXT));
            }
            if ($node instanceof QualifiedName) {
                if ($fullyQualfiedName === (string) $node->getResolvedName()) {
                    (yield new Highlight($node->getStartPosition(), $node->getEndPosition(), $this->variableKind($node)));
                }
            }
        }
    }
    private function normalizeVarName(string $varName) : string
    {
        return \ltrim($varName, '$');
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerReferenceFinder\\Model\\Highlighter', 'Phpactor\\Extension\\LanguageServerReferenceFinder\\Model\\Highlighter', \false);
