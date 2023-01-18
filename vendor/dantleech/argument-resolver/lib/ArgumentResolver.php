<?php

namespace Phpactor202301\DTL\ArgumentResolver;

use Phpactor202301\DTL\ArgumentResolver\Exception\InvalidArgumentException;
use Phpactor202301\DTL\ArgumentResolver\Exception\MissingRequiredArguments;
use Phpactor202301\DTL\ArgumentResolver\Exception\UnknownArguments;
use ReflectionClass;
use ReflectionParameter;
use RuntimeException;
class ArgumentResolver
{
    const ALLOW_UNKNOWN_ARGUMENTS = 1;
    const MATCH_TYPE = 2;
    /**
     * @var ArgumentConverter[]
     */
    private $conveters = [];
    /**
     * @var int
     */
    private $options;
    public function __construct(array $conveters = [], int $options = 0)
    {
        $this->conveters = $conveters;
        $this->options = $options;
    }
    public function resolveArguments(string $className, string $methodName, array $config)
    {
        $reflection = new ReflectionClass($className);
        if (!$reflection->hasMethod($methodName)) {
            throw new RuntimeException(\sprintf('Expected "%s" to implement a method named "%s"', $className, $methodName));
        }
        $reflectionMethod = $reflection->getMethod($methodName);
        $parameters = $reflectionMethod->getParameters();
        $arguments = $missingParameters = [];
        foreach ($parameters as $parameter) {
            if ($this->matchName($parameter, $config, $arguments)) {
                continue;
            }
            if ($this->matchType($parameter, $config, $arguments)) {
                continue;
            }
            if ($parameter->isDefaultValueAvailable()) {
                $arguments[$parameter->getName()] = $parameter->getDefaultValue();
                continue;
            }
            $missingParameters[] = $parameter;
        }
        $config = \array_diff_key($config, $arguments);
        if ($missingParameters) {
            throw new MissingRequiredArguments($reflectionMethod, $missingParameters);
        }
        if (!($this->options & self::ALLOW_UNKNOWN_ARGUMENTS) && \count($config)) {
            throw new UnknownArguments($reflectionMethod, \array_keys($config));
        }
        return \array_values($arguments);
    }
    private function instantiate(string $className, array $arguments)
    {
        $reflection = new ReflectionClass($className);
        if (!$reflection->hasMethod('__construct')) {
            return $reflection->newInstance();
        }
        $arguments = $this->resolveArguments($className, '__construct', $arguments);
        return $reflection->newInstanceArgs($arguments);
    }
    private function typeName($argument)
    {
        if (\is_object($argument)) {
            return \get_class($argument);
        }
        return \gettype($argument);
    }
    private function convertArgument(ReflectionParameter $parameter, $argument)
    {
        foreach ($this->conveters as $converter) {
            if (\false === $converter->canConvert($parameter, $argument)) {
                continue;
            }
            return $converter->convert($this, $parameter, $argument);
        }
        return $argument;
    }
    private function matchName(ReflectionParameter $parameter, array $config, array &$arguments) : bool
    {
        if (!\array_key_exists($parameter->getName(), $config)) {
            return \false;
        }
        $arguments[$parameter->getName()] = $this->convertArgument($parameter, $config[$parameter->getName()]);
        return \true;
    }
    private function matchType(ReflectionParameter $parameter, array $config, array &$arguments)
    {
        if (!($this->options & self::MATCH_TYPE)) {
            return \false;
        }
        $type = $parameter->getType();
        if (null === $type) {
            return \false;
        }
        if ($type->isBuiltin()) {
            return \false;
        }
        $parameterClass = $parameter->getClass();
        if (null === $parameterClass) {
            return \false;
        }
        foreach ($config as $key => $value) {
            if (!\is_object($value)) {
                continue;
            }
            if ($parameterClass->isInstance($value)) {
                $arguments[$key] = $this->convertArgument($parameter, $value);
                return \true;
            }
        }
        return \false;
    }
}
