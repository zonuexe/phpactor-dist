<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\Formatter;

use Phpactor202301\Phpactor\Completion\Core\Formatter\Formatter;
use Phpactor202301\Phpactor\Completion\Core\Formatter\ObjectFormatter;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionFunction;
class FunctionFormatter implements Formatter
{
    public function canFormat(object $object) : bool
    {
        return $object instanceof ReflectionFunction;
    }
    public function format(ObjectFormatter $formatter, object $function) : string
    {
        \assert($function instanceof ReflectionFunction);
        $info = [$function->name()];
        $paramInfos = [];
        foreach ($function->parameters() as $parameter) {
            $paramInfos[] = $formatter->format($parameter);
        }
        $info[] = '(' . \implode(', ', $paramInfos) . ')';
        $returnType = $function->inferredType();
        if ($returnType->isDefined()) {
            $info[] = ': ' . $formatter->format($returnType);
        }
        return \implode('', $info);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\WorseReflection\\Formatter\\FunctionFormatter', 'Phpactor\\Completion\\Bridge\\WorseReflection\\Formatter\\FunctionFormatter', \false);
