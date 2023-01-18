<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\Formatter;

use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionProperty;
use Phpactor202301\Phpactor\Completion\Core\Formatter\Formatter;
use Phpactor202301\Phpactor\Completion\Core\Formatter\ObjectFormatter;
class PropertyFormatter implements Formatter
{
    public function canFormat(object $object) : bool
    {
        return $object instanceof ReflectionProperty;
    }
    public function format(ObjectFormatter $formatter, object $object) : string
    {
        \assert($object instanceof ReflectionProperty);
        $info = [\substr((string) $object->visibility(), 0, 3)];
        if ($object->isStatic()) {
            $info[] = ' static';
        }
        $info[] = ' ';
        $info[] = '$' . $object->name();
        if ($object->inferredType()->isDefined()) {
            $info[] = ': ' . $object->inferredType()->short();
        }
        return \implode('', $info);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\WorseReflection\\Formatter\\PropertyFormatter', 'Phpactor\\Completion\\Bridge\\WorseReflection\\Formatter\\PropertyFormatter', \false);
