<?php

namespace Phpactor202301\DTL\Invoke\Internal;

interface ArgumentResolver
{
    public function resolve(Parameters $parameters, array $args) : ResolvedArguments;
}
