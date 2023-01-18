<?php

namespace Phpactor202301\DTL\ArgumentResolver\Exception;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;
class MissingRequiredArguments extends InvalidArgumentException implements ArgumentResolverException
{
    /**
     * @var array
     */
    private $missingParameters;
    /**
     * @var ReflectionClass
     */
    private $class;
    /**
     * @var ReflectionMethod
     */
    private $method;
    /**
     * @param ReflectionParameter[] $missingParameters
     */
    public function __construct(ReflectionMethod $method, array $missingParameters)
    {
        $this->missingParameters = $missingParameters;
        $this->method = $method;
        parent::__construct(\sprintf('Argument(s) "%s" are required in method "%s" of class "%s"', \implode('", "', \array_map(function (ReflectionParameter $parameter) {
            return $parameter->getName();
        }, $missingParameters)), $method->getName(), $method->getDeclaringClass()->getName()));
    }
    public function missingParameters() : array
    {
        return $this->missingParameters;
    }
    public function method() : ReflectionMethod
    {
        return $this->method;
    }
    public function class() : ReflectionClass
    {
        return $this->method->getDeclaringClass();
    }
}
