<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\Formatter;

use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionParameter;
use Phpactor202301\Phpactor\Completion\Core\Formatter\Formatter;
use Phpactor202301\Phpactor\Completion\Core\Formatter\ObjectFormatter;
class ParameterFormatter implements Formatter
{
    public function canFormat(object $object) : bool
    {
        return $object instanceof ReflectionParameter;
    }
    public function format(ObjectFormatter $formatter, object $object) : string
    {
        \assert($object instanceof ReflectionParameter);
        $paramInfo = [];
        $type = $object->inferredType();
        if ($type->isDefined()) {
            $paramInfo[] = $formatter->format($object->inferredType());
        }
        $paramInfo[] = '$' . $object->name();
        if ($object->default()->isDefined()) {
            $paramInfo[] = '= ' . \str_replace(\PHP_EOL, '', \var_export($object->default()->value(), \true));
        }
        return \implode(' ', $paramInfo);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\WorseReflection\\Formatter\\ParameterFormatter', 'Phpactor\\Completion\\Bridge\\WorseReflection\\Formatter\\ParameterFormatter', \false);
