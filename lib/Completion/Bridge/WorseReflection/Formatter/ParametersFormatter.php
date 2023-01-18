<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\Formatter;

use Phpactor202301\Phpactor\Completion\Core\Formatter\Formatter;
use Phpactor202301\Phpactor\Completion\Core\Formatter\ObjectFormatter;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionParameterCollection;
class ParametersFormatter implements Formatter
{
    public function canFormat(object $object) : bool
    {
        return $object instanceof ReflectionParameterCollection;
    }
    public function format(ObjectFormatter $formatter, object $object) : string
    {
        \assert($object instanceof ReflectionParameterCollection);
        $formatted = [];
        foreach ($object as $parameter) {
            $formatted[] = $formatter->format($parameter);
        }
        return \implode(', ', $formatted);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\WorseReflection\\Formatter\\ParametersFormatter', 'Phpactor\\Completion\\Bridge\\WorseReflection\\Formatter\\ParametersFormatter', \false);
