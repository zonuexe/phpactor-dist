<?php

namespace Phpactor202301\Phpactor\CodeTransform\Adapter\WorseReflection\Refactor;

use Phpactor202301\Phpactor\CodeBuilder\Domain\Code;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\SourceCode as PhpactorSourceCode;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\Visibility;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Updater;
use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\GenerateMethod;
use Phpactor202301\Phpactor\TextDocument\TextDocumentEdits;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ClassType;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionArgument;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode as WorseSourceCode;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Variable;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMethodCall;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\CodeTransform\Domain\Exception\TransformException;
use Phpactor202301\Phpactor\CodeBuilder\Domain\BuilderFactory;
class WorseGenerateMethod implements GenerateMethod
{
    private int $methodSuffixIndex = 0;
    public function __construct(private Reflector $reflector, private BuilderFactory $factory, private Updater $updater)
    {
    }
    public function generateMethod(SourceCode $sourceCode, int $offset, ?string $methodName = null) : TextDocumentEdits
    {
        $contextType = $this->contextType($sourceCode, $offset);
        $worseSourceCode = WorseSourceCode::fromPathAndString((string) $sourceCode->path(), (string) $sourceCode);
        $methodCall = $this->reflector->reflectMethodCall($worseSourceCode, $offset);
        $this->validate($methodCall);
        $visibility = $this->determineVisibility($contextType, $methodCall->class());
        $prototype = $this->addMethodCallToBuilder($methodCall, $visibility, $methodCall->isStatic(), $methodName);
        $sourceCode = $this->resolveSourceCode($sourceCode, $methodCall, $visibility);
        $textEdits = $this->updater->textEditsFor($prototype, Code::fromString((string) $sourceCode));
        return new TextDocumentEdits(TextDocumentUri::fromString($sourceCode->path()), $textEdits);
    }
    private function resolveSourceCode(SourceCode $sourceCode, ReflectionMethodCall $methodCall, string $visibility) : SourceCode
    {
        $containerSourceCode = SourceCode::fromStringAndPath((string) $methodCall->class()->sourceCode(), $methodCall->class()->sourceCode()->path());
        if ($sourceCode->path() != $containerSourceCode->path()) {
            return $containerSourceCode;
        }
        return $sourceCode;
    }
    private function contextType(SourceCode $sourceCode, int $offset) : ?Type
    {
        $worseSourceCode = WorseSourceCode::fromPathAndString((string) $sourceCode->path(), (string) $sourceCode);
        $reflectionOffset = $this->reflector->reflectOffset($worseSourceCode, $offset);
        /**
         * @var Variable $variable
         */
        foreach ($reflectionOffset->frame()->locals()->byName('$this') as $variable) {
            return $variable->type();
        }
        return null;
    }
    private function addMethodCallToBuilder(ReflectionMethodCall $methodCall, Visibility $visibility, bool $static, ?string $methodName) : PhpactorSourceCode
    {
        $methodName = $methodName ?: $methodCall->name();
        $reflectionClass = $methodCall->class();
        $builder = $this->factory->fromSource($reflectionClass->sourceCode());
        $classBuilder = $reflectionClass->isClass() ? $builder->class($reflectionClass->name()->short()) : $builder->interface($reflectionClass->name()->short());
        $methodBuilder = $classBuilder->method($methodName);
        $methodBuilder->visibility((string) $visibility);
        if ($static) {
            $methodBuilder->static();
        }
        /** @var ReflectionArgument $argument */
        foreach ($methodCall->arguments()->named() as $name => $argument) {
            $type = $argument->type();
            $argumentBuilder = $methodBuilder->parameter($name);
            if ($type->isDefined()) {
                $argumentBuilder->type($type->short(), $type);
                foreach ($type->allTypes()->classLike() as $classType) {
                    $builder->use($classType->toPhpString());
                }
            }
        }
        $inferredType = $methodCall->inferredReturnType();
        if ($inferredType->isDefined()) {
            $methodBuilder->returnType($inferredType->toPhpString(), $inferredType);
            // this will not render localized types see https://github.com/phpactor/phpactor/issues/1453
            // if ($inferredType->__toString() !== $inferredType->toPhpString()) {
            //     $methodBuilder->docblock('@return ' . $inferredType->__toString());
            // }
        }
        return $builder->build();
    }
    private function determineVisibility(?Type $contextType, ReflectionClassLike $targetClass) : Visibility
    {
        if (null === $contextType) {
            return Visibility::public();
        }
        if ($contextType instanceof ClassType && $contextType->name() == $targetClass->name()) {
            return Visibility::private();
        }
        return Visibility::public();
    }
    private function validate(ReflectionMethodCall $methodCall) : void
    {
        if (\false === $methodCall->class()->isClass() && \false === $methodCall->class()->isInterface()) {
            throw new TransformException(\sprintf('Can only generate methods on classes or intefaces (trying on %s)', \get_class($methodCall->class()->name())));
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Adapter\\WorseReflection\\Refactor\\WorseGenerateMethod', 'Phpactor\\CodeTransform\\Adapter\\WorseReflection\\Refactor\\WorseGenerateMethod', \false);