<?php

namespace PhpactorDist\DTL\Invoke\Internal\ArgumentResolver;

use PhpactorDist\DTL\Invoke\Internal\ArgumentResolver;
use PhpactorDist\DTL\Invoke\Internal\Parameters;
use PhpactorDist\DTL\Invoke\Internal\ResolvedArguments;
class NamedArgumentResolver implements ArgumentResolver
{
    /**
     * {@inheritDoc}
     */
    public function resolve(Parameters $parameters, array $args) : ResolvedArguments
    {
        $resolved = [];
        $unresolved = [];
        foreach ($args as $name => $value) {
            if (!$parameters->has($name)) {
                $unresolved[$name] = $value;
                continue;
            }
            $resolved[$name] = $value;
        }
        return new ResolvedArguments($resolved, $unresolved);
    }
}
