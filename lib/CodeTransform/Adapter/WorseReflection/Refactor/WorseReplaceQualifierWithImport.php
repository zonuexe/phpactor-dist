<?php

namespace Phpactor202301\Phpactor\CodeTransform\Adapter\WorseReflection\Refactor;

use Phpactor202301\Microsoft\PhpParser\Node\QualifiedName;
use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\Phpactor\CodeBuilder\Domain\BuilderFactory;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Code;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Updater;
use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\ReplaceQualifierWithImport;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\TextDocument\TextDocumentEdits;
use Phpactor202301\Phpactor\TextDocument\TextEdit;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ClassType;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
class WorseReplaceQualifierWithImport implements ReplaceQualifierWithImport
{
    private Parser $parser;
    public function __construct(private Reflector $reflector, private BuilderFactory $factory, private Updater $updater, Parser $parser = null)
    {
        $this->parser = $parser ?: new Parser();
    }
    public function getTextEdits(SourceCode $sourceCode, int $offset) : TextDocumentEdits
    {
        $symbolContext = $this->reflector->reflectOffset($sourceCode->__toString(), $offset)->symbolContext();
        $type = $symbolContext->type();
        if (!$type instanceof ClassType) {
            return new TextDocumentEdits($sourceCode->uri(), TextEdits::none());
        }
        $textEdits = $this->getTextEditForImports($sourceCode, $type);
        $newClassName = $type->name()->short();
        $position = $symbolContext->symbol()->position();
        return new TextDocumentEdits($sourceCode->uri(), $textEdits->merge(TextEdits::fromTextEdits([TextEdit::create($position->start(), $position->end() - $position->start(), $newClassName)])));
    }
    public function canReplaceWithImport(SourceCode $source, int $offset) : bool
    {
        $node = $this->parser->parseSourceFile($source->__toString());
        $targetNode = $node->getDescendantNodeAtPosition($offset);
        if ($targetNode instanceof QualifiedName) {
            return $targetNode->isFullyQualifiedName();
        }
        return \false;
    }
    private function getTextEditForImports(SourceCode $sourceCode, ClassType $type) : TextEdits
    {
        $sourceBuilder = $this->factory->fromSource($sourceCode);
        $sourceBuilder->use((string) $type->name());
        return $this->updater->textEditsFor($sourceBuilder->build(), Code::fromString((string) $sourceCode));
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Adapter\\WorseReflection\\Refactor\\WorseReplaceQualifierWithImport', 'Phpactor\\CodeTransform\\Adapter\\WorseReflection\\Refactor\\WorseReplaceQualifierWithImport', \false);
