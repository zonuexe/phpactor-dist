<?php

namespace Phpactor202301\Phpactor\CodeTransform\Adapter\WorseReflection\Refactor;

use Phpactor202301\Phpactor\CodeBuilder\Domain\Builder\MethodBuilder;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\SourceCode as PhpactorSourceCode;
use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\OverrideMethod;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ClassType;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Updater;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Builder\SourceCodeBuilder;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionParameter;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMethod;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Code;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClass;
use Phpactor202301\Phpactor\CodeTransform\Domain\Exception\TransformException;
use Phpactor202301\Phpactor\CodeBuilder\Domain\BuilderFactory;
class WorseOverrideMethod implements OverrideMethod
{
    public function __construct(private Reflector $reflector, private BuilderFactory $factory, private Updater $updater)
    {
    }
    public function overrideMethod(SourceCode $source, string $className, string $methodName) : string
    {
        $class = $this->getReflectionClass($source, $className);
        $method = $this->getAncestorReflectionMethod($class, $methodName);
        $methodBuilder = $this->getMethodPrototype($class, $method);
        $sourcePrototype = $this->getSourcePrototype($class, $method, $source, $methodBuilder);
        return $this->updater->textEditsFor($sourcePrototype, Code::fromString((string) $source))->apply($source);
    }
    private function getReflectionClass(SourceCode $source, string $className) : ReflectionClass
    {
        $builder = TextDocumentBuilder::create($source)->language('php');
        if ($source->path()) {
            $builder->uri($source->uri());
        }
        $classes = $this->reflector->reflectClassesIn($builder->build())->classes();
        return $classes->get($className);
    }
    private function getMethodPrototype(ReflectionClass $class, ReflectionMethod $method) : MethodBuilder
    {
        /** @var ReflectionMethod $method */
        $builder = $this->factory->fromSource($method->class()->sourceCode());
        $methodBuilder = $builder->class($method->declaringClass()->name()->short())->method($method->name());
        return $methodBuilder;
    }
    private function getAncestorReflectionMethod(ReflectionClass $class, string $methodName) : ReflectionMethod
    {
        if (null === $class->parent()) {
            throw new TransformException(\sprintf('Class "%s" has no parent, cannot override any method', $class->name()));
        }
        return $class->parent()->methods()->get($methodName);
    }
    private function getSourcePrototype(ReflectionClass $class, ReflectionMethod $method, SourceCode $source, MethodBuilder $methodBuilder) : PhpactorSourceCode
    {
        $sourceBuilder = $this->factory->fromSource($source);
        $sourceBuilder->class($class->name()->short())->add($methodBuilder);
        $this->importClasses($class, $method, $sourceBuilder);
        return $sourceBuilder->build();
    }
    private function importClasses(ReflectionClass $class, ReflectionMethod $method, SourceCodeBuilder $sourceBuilder) : void
    {
        $usedClasses = [];
        foreach ($method->returnType()->allTypes()->classLike() as $classType) {
            $usedClasses[] = $classType;
        }
        /**
         * @var ReflectionParameter $parameter */
        foreach ($method->parameters() as $parameter) {
            foreach ($parameter->type()->expandTypes()->classLike() as $classType) {
                $usedClasses[] = $classType;
            }
        }
        foreach ($usedClasses as $usedClass) {
            \assert($usedClass instanceof ClassType);
            $className = $usedClass->name();
            if ($class->name()->namespace() == $className->namespace()) {
                continue;
            }
            $sourceBuilder->use((string) $usedClass);
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Adapter\\WorseReflection\\Refactor\\WorseOverrideMethod', 'Phpactor\\CodeTransform\\Adapter\\WorseReflection\\Refactor\\WorseOverrideMethod', \false);
