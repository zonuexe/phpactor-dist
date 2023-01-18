<?php

namespace Phpactor202301\Phpactor\CodeTransform\Adapter\WorseReflection\Refactor;

use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\ExtractConstant;
use Phpactor202301\Phpactor\TextDocument\TextDocumentEdits;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use Phpactor202301\Phpactor\TextDocument\TextEdit;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Updater;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Code;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Builder\SourceCodeBuilder;
use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\Microsoft\PhpParser\ClassLike;
use Phpactor202301\Microsoft\PhpParser\Node\StringLiteral;
use Phpactor202301\Microsoft\PhpParser\Node\NumericLiteral;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContext;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\CodeTransform\Domain\Exception\TransformException;
use Phpactor202301\Phpactor\WorseReflection\TypeUtil;
class WorseExtractConstant implements ExtractConstant
{
    private Parser $parser;
    public function __construct(private Reflector $reflector, private Updater $updater, Parser $parser = null)
    {
        $this->parser = $parser ?: new Parser();
    }
    public function extractConstant(SourceCode $sourceCode, int $offset, string $constantName) : TextDocumentEdits
    {
        $symbolInformation = $this->reflector->reflectOffset($sourceCode->__toString(), $offset)->symbolContext();
        $textEdits = $this->addConstant($sourceCode, $symbolInformation, $constantName);
        $textEdits = $textEdits->merge($this->replaceValues($sourceCode, $offset, $constantName));
        return new TextDocumentEdits(TextDocumentUri::fromString($sourceCode->path()), $textEdits);
    }
    public function canExtractConstant(SourceCode $source, int $offset) : bool
    {
        $node = $this->parser->parseSourceFile($source->__toString());
        $targetNode = $node->getDescendantNodeAtPosition($offset);
        try {
            $this->getComparableValue($targetNode);
        } catch (TransformException) {
            return \false;
        }
        return \true;
    }
    private function addConstant(string $sourceCode, NodeContext $symbolInformation, string $constantName) : TextEdits
    {
        $symbol = $symbolInformation->symbol();
        $builder = SourceCodeBuilder::create();
        $classType = $symbolInformation->containerType()->expandTypes()->classLike()->firstOrNull();
        if (!$classType) {
            throw new TransformException(\sprintf('Node does not belong to a class'));
        }
        $builder->namespace($classType->name()->namespace());
        $builder->class($classType->name()->short())->constant($constantName, TypeUtil::valueOrNull($symbolInformation->type()))->end();
        return $this->updater->textEditsFor($builder->build(), Code::fromString($sourceCode));
    }
    private function replaceValues(SourceCode $sourceCode, int $offset, string $constantName) : TextEdits
    {
        $node = $this->parser->parseSourceFile($sourceCode->__toString());
        $targetNode = $node->getDescendantNodeAtPosition($offset);
        $targetValue = $this->getComparableValue($targetNode);
        $classNode = $targetNode->getFirstAncestor(ClassLike::class);
        if (null === $classNode) {
            throw new TransformException('Node does not belong to a class');
        }
        $textEdits = [];
        foreach ($classNode->getDescendantNodes() as $node) {
            if (!$node instanceof $targetNode) {
                continue;
            }
            if ($targetValue == $this->getComparableValue($node)) {
                $textEdits[] = TextEdit::create($node->getStartPosition(), $node->getEndPosition() - $node->getStartPosition(), 'self::' . $constantName);
            }
        }
        return TextEdits::fromTextEdits($textEdits);
    }
    private function getComparableValue(Node $node) : string
    {
        if ($node instanceof StringLiteral) {
            return $node->getStringContentsText();
        }
        if ($node instanceof NumericLiteral) {
            return $node->getText();
        }
        throw new TransformException(\sprintf('Do not know how to replace node of type "%s"', \get_class($node)));
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Adapter\\WorseReflection\\Refactor\\WorseExtractConstant', 'Phpactor\\CodeTransform\\Adapter\\WorseReflection\\Refactor\\WorseExtractConstant', \false);