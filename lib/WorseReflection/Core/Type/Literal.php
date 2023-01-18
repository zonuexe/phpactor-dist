<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

interface Literal
{
    /**
     * @return mixed
     */
    public function value();
    /**
     * @param mixed $value
     * @return static
     */
    public function withValue($value);
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\Literal', 'Phpactor\\WorseReflection\\Core\\Type\\Literal', \false);
