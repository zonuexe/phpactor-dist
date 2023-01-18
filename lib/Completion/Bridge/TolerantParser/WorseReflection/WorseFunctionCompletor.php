<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\WorseReflection;

use Generator;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\DelimitedList\QualifiedNameList;
use Phpactor202301\Microsoft\PhpParser\Node\MethodDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\Parameter;
use Phpactor202301\Microsoft\PhpParser\Node\QualifiedName;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantCompletor;
use Phpactor202301\Phpactor\Completion\Core\Formatter\ObjectFormatter;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\NotFound;
use Phpactor202301\Phpactor\WorseReflection\Core\Name;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionFunction;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
class WorseFunctionCompletor implements TolerantCompletor
{
    public function __construct(private Reflector $reflector, private ObjectFormatter $formatter, private ObjectFormatter $snippetFormatter)
    {
    }
    public function complete(Node $node, TextDocument $source, ByteOffset $offset) : Generator
    {
        if (\false === $node instanceof QualifiedName) {
            return \true;
        }
        if ($node->parent instanceof MethodDeclaration) {
            return \true;
        }
        if ($node->parent instanceof QualifiedNameList) {
            return \true;
        }
        if ($node->parent instanceof Parameter) {
            return \true;
        }
        $functionNames = $this->reflectedFunctions($source);
        $functionNames = $this->definedNamesFor($functionNames, $node->getText());
        $functions = $this->functionReflections($functionNames);
        /** @var ReflectionFunction $functionReflection */
        foreach ($functions as $functionReflection) {
            (yield Suggestion::createWithOptions($functionReflection->name()->short(), ['type' => Suggestion::TYPE_FUNCTION, 'short_description' => $this->formatter->format($functionReflection), 'documentation' => $functionReflection->docblock()->formatted(), 'snippet' => $this->snippetFormatter->format($functionReflection)]));
        }
        return \true;
    }
    private function definedNamesFor(array $reflectedFunctions, string $partialName) : Generator
    {
        $functions = \get_defined_functions();
        $functions['reflected'] = $reflectedFunctions;
        return $this->filterFunctions($functions, $partialName);
    }
    private function reflectedFunctions(TextDocument $source) : array
    {
        $functionNames = [];
        foreach ($this->reflector->reflectFunctionsIn($source) as $function) {
            $functionNames[] = $function->name()->full();
        }
        return $functionNames;
    }
    private function filterFunctions(array $functions, string $partialName) : Generator
    {
        foreach ($functions as $type => $functionNames) {
            foreach ($functionNames as $functionName) {
                $functionName = Name::fromString($functionName);
                if (\str_starts_with($functionName->short(), $partialName)) {
                    (yield $functionName);
                }
            }
        }
    }
    private function functionReflections(Generator $functionNames) : Generator
    {
        foreach ($functionNames as $functionName) {
            try {
                (yield $this->reflector->reflectFunction($functionName));
            } catch (NotFound) {
            }
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\TolerantParser\\WorseReflection\\WorseFunctionCompletor', 'Phpactor\\Completion\\Bridge\\TolerantParser\\WorseReflection\\WorseFunctionCompletor', \false);