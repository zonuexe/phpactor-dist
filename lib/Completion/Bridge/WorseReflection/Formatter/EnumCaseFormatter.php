<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\Formatter;

use Phpactor202301\Phpactor\Completion\Core\Formatter\Formatter;
use Phpactor202301\Phpactor\Completion\Core\Formatter\ObjectFormatter;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionEnumCase;
class EnumCaseFormatter implements Formatter
{
    public function canFormat(object $object) : bool
    {
        return $object instanceof ReflectionEnumCase;
    }
    public function format(ObjectFormatter $formatter, object $object) : string
    {
        \assert($object instanceof ReflectionEnumCase);
        return \sprintf('case %s', $object->name());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\WorseReflection\\Formatter\\EnumCaseFormatter', 'Phpactor\\Completion\\Bridge\\WorseReflection\\Formatter\\EnumCaseFormatter', \false);
