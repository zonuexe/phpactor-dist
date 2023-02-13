<?php

namespace PhpactorDist\DTL\Invoke\Internal\ArgumentResolver;

use PhpactorDist\DTL\Invoke\Internal\ArgumentResolver;
use PhpactorDist\DTL\Invoke\Internal\Parameters;
use PhpactorDist\DTL\Invoke\Internal\ResolvedArguments;
class TypedArgumentResolver implements ArgumentResolver
{
    /**
     * {@inheritDoc}
     */
    public function resolve(Parameters $parameters, array $arguments) : ResolvedArguments
    {
        $resolved = [];
        $unresolved = [];
        foreach ($arguments as $name => $value) {
            if ($parameter = $parameters->findOneByValueType($value)) {
                $resolved[$parameter->getName()] = $value;
                continue;
            }
            $unresolved[$name] = $value;
        }
        return new ResolvedArguments($resolved, $unresolved);
    }
}
