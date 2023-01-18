<?php

namespace Phpactor202301\Phpactor\CodeTransform\Adapter\WorseReflection\Transformer;

use Phpactor202301\Phpactor\CodeTransform\Domain\Diagnostic;
use Phpactor202301\Phpactor\CodeTransform\Domain\Diagnostics;
use Phpactor202301\Phpactor\CodeTransform\Domain\Transformer;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\TextDocument\ByteOffsetRange;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode as WorseSourceCode;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClass;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Updater;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Builder\SourceCodeBuilder;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Code;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMethod;
use Phpactor202301\Phpactor\CodeBuilder\Domain\BuilderFactory;
class ImplementContracts implements Transformer
{
    public function __construct(private Reflector $reflector, private Updater $updater, private BuilderFactory $factory)
    {
    }
    public function diagnostics(SourceCode $source) : Diagnostics
    {
        $diagnostics = [];
        $classes = $this->reflector->reflectClassesIn(WorseSourceCode::fromString((string) $source));
        foreach ($classes->concrete() as $class) {
            \assert($class instanceof ReflectionClass);
            $missingMethods = $this->missingClassMethods($class);
            if (0 === \count($missingMethods)) {
                continue;
            }
            $diagnostics[] = new Diagnostic(ByteOffsetRange::fromInts($class->position()->start(), $class->position()->start() + 5 + \strlen($class->name()->__toString())), \sprintf('Missing methods "%s"', \implode('", "', \array_map(function (ReflectionMethod $method) {
                return $method->name();
            }, $missingMethods))), Diagnostic::ERROR);
        }
        return new Diagnostics($diagnostics);
    }
    public function transform(SourceCode $source) : TextEdits
    {
        $classes = $this->reflector->reflectClassesIn(WorseSourceCode::fromString((string) $source));
        $edits = [];
        $sourceCodeBuilder = SourceCodeBuilder::create();
        /** @var ReflectionClass $class */
        foreach ($classes->concrete() as $class) {
            $classBuilder = $sourceCodeBuilder->class($class->name()->short());
            $missingMethods = $this->missingClassMethods($class);
            if (empty($missingMethods)) {
                continue;
            }
            /** @var ReflectionMethod $missingMethod */
            foreach ($missingMethods as $missingMethod) {
                $builder = $this->factory->fromSource($missingMethod->declaringClass()->sourceCode());
                $methodBuilder = $builder->classLike($missingMethod->declaringClass()->name()->short())->method($missingMethod->name());
                $missingMethodReturnType = $missingMethod->returnType();
                foreach ($missingMethodReturnType->allTypes()->classLike() as $type) {
                    $sourceCodeBuilder->use($type->name());
                }
                foreach ($missingMethod->parameters() as $parameter) {
                    $parameterType = $parameter->type();
                    foreach ($parameterType->allTypes()->classLike() as $classType) {
                        if ($classType->name()->namespace() != $class->name()->namespace()) {
                            $sourceCodeBuilder->use($classType->name());
                        }
                    }
                }
                $classBuilder->add($methodBuilder);
            }
        }
        return $this->updater->textEditsFor($sourceCodeBuilder->build(), Code::fromString((string) $source));
    }
    private function missingClassMethods(ReflectionClass $class) : array
    {
        $methods = [];
        $reflectionMethods = $class->methods();
        foreach ($class->interfaces() as $interface) {
            foreach ($interface->methods() as $method) {
                if ($reflectionMethods->has($method->name())) {
                    continue;
                }
                $methods[] = $method;
            }
        }
        foreach ($class->methods()->abstract() as $method) {
            \assert($method instanceof ReflectionMethod);
            if ($method->declaringClass()->name() == $class->name()) {
                continue;
            }
            foreach ($class->traits() as $trait) {
                if ($trait->methods()->has($method->name())) {
                    continue 2;
                }
            }
            $methods[] = $method;
        }
        return $methods;
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Adapter\\WorseReflection\\Transformer\\ImplementContracts', 'Phpactor\\CodeTransform\\Adapter\\WorseReflection\\Transformer\\ImplementContracts', \false);