<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerSymbolProvider\Adapter;

use Generator;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\ClassConstDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\ClassMembersNode;
use Phpactor202301\Microsoft\PhpParser\Node\ConstElement;
use Phpactor202301\Microsoft\PhpParser\Node\DelimitedList\ConstElementList;
use Phpactor202301\Microsoft\PhpParser\Node\DelimitedList\ExpressionList;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\Variable;
use Phpactor202301\Microsoft\PhpParser\Node\InterfaceMembers;
use Phpactor202301\Microsoft\PhpParser\Node\MethodDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\PropertyDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\ClassDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\FunctionDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\InterfaceDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\TraitDeclaration;
use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\PositionConverter;
use Phpactor202301\Phpactor\Extension\LanguageServerSymbolProvider\Model\DocumentSymbolProvider;
use Phpactor202301\Phpactor\LanguageServerProtocol\DocumentSymbol;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServerProtocol\SymbolKind;
class TolerantDocumentSymbolProvider implements DocumentSymbolProvider
{
    public function __construct(private Parser $parser)
    {
    }
    public function provideFor(string $source) : array
    {
        $rootNode = $this->parser->parseSourceFile($source);
        return $this->buildNodes($rootNode->getChildNodes(), $source);
    }
    /**
     * @return array<DocumentSymbol>
     */
    private function buildNodes(Generator $nodes, string $source) : array
    {
        $symbols = [];
        foreach ($nodes as $childNode) {
            if (null !== ($symbol = $this->buildNode($childNode, $source))) {
                $symbols[] = $symbol;
            }
        }
        return $symbols;
    }
    private function buildNode(Node $node, string $source) : ?DocumentSymbol
    {
        if ($node instanceof FunctionDeclaration) {
            return new DocumentSymbol((string) $node->name->getText($source), SymbolKind::FUNCTION, new Range(PositionConverter::intByteOffsetToPosition($node->getStartPosition(), $source), PositionConverter::intByteOffsetToPosition($node->getEndPosition(), $source)), new Range(PositionConverter::intByteOffsetToPosition($node->name->getStartPosition(), $source), PositionConverter::intByteOffsetToPosition($node->name->getEndPosition(), $source)), null, null, $this->buildNodes($this->memberNodes($node), $source));
        }
        if ($node instanceof ClassDeclaration) {
            return new DocumentSymbol((string) $node->name->getText($source), SymbolKind::CLASS_, new Range(PositionConverter::intByteOffsetToPosition($node->getStartPosition(), $source), PositionConverter::intByteOffsetToPosition($node->getEndPosition(), $source)), new Range(PositionConverter::intByteOffsetToPosition($node->name->getStartPosition(), $source), PositionConverter::intByteOffsetToPosition($node->name->getEndPosition(), $source)), null, null, $this->buildNodes($this->memberNodes($node), $source));
        }
        if ($node instanceof InterfaceDeclaration) {
            return new DocumentSymbol((string) $node->name->getText($source), SymbolKind::INTERFACE, new Range(PositionConverter::intByteOffsetToPosition($node->getStartPosition(), $source), PositionConverter::intByteOffsetToPosition($node->getEndPosition(), $source)), new Range(PositionConverter::intByteOffsetToPosition($node->name->getStartPosition(), $source), PositionConverter::intByteOffsetToPosition($node->name->getEndPosition(), $source)), null, null, $this->buildNodes($this->memberNodes($node), $source));
        }
        if ($node instanceof TraitDeclaration) {
            return new DocumentSymbol((string) $node->name->getText($source), SymbolKind::CLASS_, new Range(PositionConverter::intByteOffsetToPosition($node->getStartPosition(), $source), PositionConverter::intByteOffsetToPosition($node->getEndPosition(), $source)), new Range(PositionConverter::intByteOffsetToPosition($node->name->getStartPosition(), $source), PositionConverter::intByteOffsetToPosition($node->name->getEndPosition(), $source)), null, null, $this->buildNodes($this->memberNodes($node), $source));
        }
        if ($node instanceof MethodDeclaration) {
            $name = (string) $node->name->getText($source);
            return new DocumentSymbol($name, $name === '__construct' ? SymbolKind::CONSTRUCTOR : SymbolKind::METHOD, new Range(PositionConverter::intByteOffsetToPosition($node->getStartPosition(), $source), PositionConverter::intByteOffsetToPosition($node->getEndPosition(), $source)), new Range(PositionConverter::intByteOffsetToPosition($node->name->getStartPosition(), $source), PositionConverter::intByteOffsetToPosition($node->name->getEndPosition(), $source)), null, null, []);
        }
        if ($node instanceof Variable) {
            if ($node->getFirstAncestor(PropertyDeclaration::class)) {
                return new DocumentSymbol((string) $node->getName(), SymbolKind::PROPERTY, new Range(PositionConverter::intByteOffsetToPosition($node->parent->getStartPosition(), $source), PositionConverter::intByteOffsetToPosition($node->parent->getEndPosition(), $source)), new Range(PositionConverter::intByteOffsetToPosition($node->getStartPosition(), $source), PositionConverter::intByteOffsetToPosition($node->getEndPosition(), $source)), null, null, []);
            }
        }
        if ($node instanceof ConstElement) {
            return new DocumentSymbol((string) $node->getName(), SymbolKind::CONSTANT, new Range(PositionConverter::intByteOffsetToPosition($node->getStartPosition(), $source), PositionConverter::intByteOffsetToPosition($node->getEndPosition(), $source)), new Range(PositionConverter::intByteOffsetToPosition($node->name->getStartPosition(), $source), PositionConverter::intByteOffsetToPosition($node->name->getEndPosition(), $source)), null, null, []);
        }
        return null;
    }
    private function memberNodes(Node $node) : Generator
    {
        return $node->getDescendantNodes(function (Node $node) {
            return $node instanceof InterfaceMembers || $node instanceof ClassMembersNode || $node instanceof MethodDeclaration || $node instanceof PropertyDeclaration || $node instanceof ClassConstDeclaration || $node instanceof ExpressionList && $node->parent instanceof PropertyDeclaration || $node instanceof ConstElementList && $node->parent instanceof ClassConstDeclaration;
        });
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerSymbolProvider\\Adapter\\TolerantDocumentSymbolProvider', 'Phpactor\\Extension\\LanguageServerSymbolProvider\\Adapter\\TolerantDocumentSymbolProvider', \false);