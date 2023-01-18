<?php

namespace Phpactor202301\Phpactor\CodeTransform\Adapter\WorseReflection\Refactor;

use Phpactor202301\Microsoft\PhpParser\Node\Expression\ObjectCreationExpression;
use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\Phpactor\CodeBuilder\Domain\BuilderFactory;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Code;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Updater;
use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\GenerateConstructor;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\TextDocument\TextDocumentEdits;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use Phpactor202301\Phpactor\TextDocument\WorkspaceEdits;
use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\ReflectionObjectCreationExpression;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\NotFound;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionArgument;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
class WorseGenerateConstructor implements GenerateConstructor
{
    public function __construct(private Reflector $reflector, private BuilderFactory $factory, private Updater $updater, private Parser $parser)
    {
    }
    public function generateMethod(TextDocument $document, ByteOffset $offset) : WorkspaceEdits
    {
        $node = $this->parser->parseSourceFile($document->__toString())->getDescendantNodeAtPosition($offset->toInt());
        $node = $node->getFirstAncestor(ObjectCreationExpression::class);
        if (!$node instanceof ObjectCreationExpression) {
            return WorkspaceEdits::none();
        }
        try {
            $newObject = $this->reflector->reflectNode($document, $node->getStartPosition());
        } catch (NotFound) {
            return WorkspaceEdits::none();
        }
        if (!$newObject instanceof ReflectionObjectCreationExpression) {
            return WorkspaceEdits::none();
        }
        try {
            if ($newObject->class()->methods()->has('__construct')) {
                return WorkspaceEdits::none();
            }
        } catch (NotFound) {
            return WorkspaceEdits::none();
        }
        $arguments = $newObject->arguments();
        if (\count($arguments) === 0) {
            return WorkspaceEdits::none();
        }
        $builder = $this->factory->fromSource($newObject->class()->sourceCode());
        $class = $builder->class($newObject->class()->name()->short());
        $method = $class->method('__construct');
        foreach ($arguments->named() as $name => $argument) {
            \assert($argument instanceof ReflectionArgument);
            $type = $argument->type();
            foreach ($type->allTypes()->classLike() as $classType) {
                $builder->use($classType->__toString());
            }
            $param = $method->parameter($name);
            $param->type($argument->type()->short());
        }
        return new WorkspaceEdits(new TextDocumentEdits(TextDocumentUri::fromString($newObject->class()->sourceCode()->mustGetUri()), $this->updater->textEditsFor($builder->build(), Code::fromString($newObject->class()->sourceCode()))));
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Adapter\\WorseReflection\\Refactor\\WorseGenerateConstructor', 'Phpactor\\CodeTransform\\Adapter\\WorseReflection\\Refactor\\WorseGenerateConstructor', \false);
