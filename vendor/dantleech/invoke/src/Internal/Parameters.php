<?php

namespace PhpactorDist\DTL\Invoke\Internal;

use ReflectionClass;
use ReflectionFunctionAbstract;
use ReflectionMethod;
use ReflectionParameter;
use RuntimeException;
class Parameters
{
    /**
     * @var array
     */
    private $parameterMap;
    /**
     * @var ReflectionFunctionAbstract
     */
    private $owner;
    /**
     * @param array<string,ReflectionParameter> $parameterMap
     */
    public function __construct(ReflectionFunctionAbstract $function, array $parameterMap)
    {
        $this->owner = $function;
        $this->parameterMap = $parameterMap;
    }
    /**
     * @param class-string $className
     */
    public static function fromClassNameAndMethod(string $className, string $method) : self
    {
        $class = new ReflectionClass($className);
        $method = $class->getMethod($method);
        $parameters = (array) \array_combine(\array_map(function (ReflectionParameter $parameter) {
            return $parameter->getName();
        }, $method->getParameters()), $method->getParameters());
        /** @phpstan-ignore-next-line */
        return new self($method, $parameters);
    }
    public static function fromRefelctionFunctionAbstract(ReflectionFunctionAbstract $function) : self
    {
        /** @phpstan-ignore-next-line */
        return new self($function, (array) \array_combine(\array_map(function (ReflectionParameter $function) {
            return $function->getName();
        }, $function->getParameters()), $function->getParameters()));
    }
    public function required() : self
    {
        return new self($this->owner, \array_filter($this->parameterMap, function (ReflectionParameter $parameter) {
            return (bool) (!$parameter->isDefaultValueAvailable());
        }));
    }
    /**
     * @return array<string>
     */
    public function keys() : array
    {
        return \array_keys($this->parameterMap);
    }
    /**
     * @return array<string,ReflectionParameter>
     */
    public function toArray() : array
    {
        return $this->parameterMap;
    }
    public function defaults() : self
    {
        return new self($this->owner, \array_map(function (ReflectionParameter $parameter) {
            return $parameter->isDefaultValueAvailable() ? $parameter->getDefaultValue() : null;
        }, $this->parameterMap));
    }
    public function has(string $key) : bool
    {
        return \array_key_exists($key, $this->parameterMap);
    }
    public function get(string $key) : ReflectionParameter
    {
        if (!$this->has($key)) {
            throw new RuntimeException(\sprintf('No parameter exists with key "%s"', $key));
        }
        return $this->parameterMap[$key];
    }
    /**
     * @param mixed $value
     */
    public function findOneByValueType($value) : ?ReflectionParameter
    {
        foreach ($this->parameterMap as $name => $parameter) {
            $type = $parameter->getType();
            if (null === $type) {
                continue;
            }
            if (\gettype($value) !== 'object' && $type->isBuiltin() && $type->getName() === $this->resolveInternalTypeName($value)) {
                return $parameter;
            }
            if (\gettype($value) === 'object') {
                if (!\is_a($value, $type->getName())) {
                    continue;
                }
                return $parameter;
            }
        }
        return null;
    }
    /**
     * @param mixed $value
     */
    private function resolveInternalTypeName($value) : string
    {
        $type = \gettype($value);
        if ($type === 'integer') {
            return 'int';
        }
        if ($type === 'boolean') {
            return 'bool';
        }
        return $type;
    }
    public function describeOwner() : string
    {
        if ($this->owner instanceof ReflectionMethod) {
            return \sprintf('%s#%s', $this->owner->getDeclaringClass()->getName(), $this->owner->getName());
        }
        return $this->owner->getName();
    }
}
