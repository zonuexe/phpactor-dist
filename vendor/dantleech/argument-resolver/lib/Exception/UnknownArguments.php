<?php

namespace Phpactor202301\DTL\ArgumentResolver\Exception;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;
class UnknownArguments extends InvalidArgumentException implements ArgumentResolverException
{
    /**
     * @var ReflectionMethod
     */
    private $method;
    /**
     * @var array
     */
    private $unknownArgumentNames;
    /**
     * @param string[] $unknownArgumentNames
     */
    public function __construct(ReflectionMethod $method, array $unknownArgumentNames)
    {
        $this->unknownArgumentNames = $unknownArgumentNames;
        $this->method = $method;
        parent::__construct(\sprintf('Parameter(s) "%s" do not exist in method "%s", valid parameter(s): "%s"', \implode('", "', $unknownArgumentNames), $method->getName(), \implode('", "', \array_map(function (ReflectionParameter $parameter) {
            return $parameter->getName();
        }, $method->getParameters()))));
    }
    /**
     * @return string[]
     */
    public function unknownArgumentNames() : array
    {
        return $this->unknownArgumentNames;
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
