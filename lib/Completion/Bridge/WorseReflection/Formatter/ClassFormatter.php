<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\Formatter;

use Phpactor202301\Phpactor\Completion\Core\Formatter\Formatter;
use Phpactor202301\Phpactor\Completion\Core\Formatter\ObjectFormatter;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClass;
class ClassFormatter implements Formatter
{
    public function canFormat(object $object) : bool
    {
        return $object instanceof ReflectionClass;
    }
    public function format(ObjectFormatter $formatter, object $class) : string
    {
        \assert($class instanceof ReflectionClass);
        $info = [];
        if ($class->deprecation()->isDefined()) {
            $info[] = '⚠ ';
        }
        $info[] = $class->name();
        if ($class->methods()->has('__construct')) {
            $info[] = '(';
            $info[] = $formatter->format($class->methods()->get('__construct')->parameters());
            $info[] = ')';
        }
        return \implode('', $info);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\WorseReflection\\Formatter\\ClassFormatter', 'Phpactor\\Completion\\Bridge\\WorseReflection\\Formatter\\ClassFormatter', \false);
