<?php

namespace Phpactor202301\Phpactor\CodeTransform\Adapter\WorseReflection\Refactor;

use InvalidArgumentException;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Prototype\SourceCode as PrototypeSourceCode;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
use RuntimeException;
use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClass;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionProperty;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Updater;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Builder\SourceCodeBuilder;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\CodeBuilder\Domain\Code;
use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\PropertyAccessGenerator;
class WorseGenerateAccessor implements PropertyAccessGenerator
{
    private bool $upperCaseFirst;
    public function __construct(private Reflector $reflector, private Updater $updater, private string $prefix = '', bool $upperCaseFirst = null)
    {
        $this->upperCaseFirst = $prefix && $upperCaseFirst === null || $upperCaseFirst;
    }
    /**
     * @param string[] $propertyNames
     */
    public function generate(SourceCode $sourceCode, array $propertyNames, int $offset) : TextEdits
    {
        $class = $this->class((string) $sourceCode, $offset);
        $allProperties = $class->properties();
        $properties = \array_map(fn(string $name) => $allProperties->get($name), $propertyNames);
        $prototype = $this->buildPrototype($class, $properties);
        $sourceCode = $this->sourceFromClassName($sourceCode, $class->name());
        return $this->updater->textEditsFor($prototype, Code::fromString((string) $sourceCode));
    }
    private function formatName(string $name) : string
    {
        if ($this->upperCaseFirst) {
            $name = \ucfirst($name);
        }
        return $this->prefix . $name;
    }
    /**
     * @param ReflectionProperty[] $properties
     */
    private function buildPrototype(ReflectionClass $class, array $properties) : PrototypeSourceCode
    {
        $builder = SourceCodeBuilder::create();
        $className = $class->name();
        $builder->namespace($className->namespace());
        foreach ($properties as $reflectionProperty) {
            $method = $builder->class($className->short())->method($this->formatName($reflectionProperty->name()));
            $method->body()->line(\sprintf('return $this->%s;', $reflectionProperty->name()));
            $type = $reflectionProperty->inferredType();
            if ($type->isDefined()) {
                $method->returnType($type->short(), $type);
            }
        }
        return $builder->build();
    }
    private function sourceFromClassName(SourceCode $sourceCode, ClassName $className) : SourceCode
    {
        $containingClass = $this->reflector->reflectClassLike($className);
        $worseSourceCode = $containingClass->sourceCode();
        if ($worseSourceCode->path() != $sourceCode->path()) {
            return $sourceCode;
        }
        return SourceCode::fromStringAndPath($worseSourceCode->__toString(), $worseSourceCode->path());
    }
    private function class(string $source, int $offset) : ReflectionClass
    {
        $classes = $this->reflector->reflectClassesIn($source)->classes();
        if (0 === $classes->count()) {
            throw new InvalidArgumentException('No classes in source file');
        }
        if (1 === $classes->count()) {
            return $classes->first();
        }
        foreach ($classes as $class) {
            $position = $class->position();
            if ($position->start() <= $offset && $offset <= $position->end()) {
                return $class;
            }
        }
        throw new RuntimeException('Impossible to determine which class to use.');
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Adapter\\WorseReflection\\Refactor\\WorseGenerateAccessor', 'Phpactor\\CodeTransform\\Adapter\\WorseReflection\\Refactor\\WorseGenerateAccessor', \false);