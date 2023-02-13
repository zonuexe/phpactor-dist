<?php

namespace PhpactorDist\DTL\Invoke\Internal;

interface ArgumentResolver
{
    public function resolve(Parameters $parameters, array $args) : ResolvedArguments;
}
