<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\Formatter;

use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Variable;
use Phpactor202301\Phpactor\Completion\Core\Formatter\Formatter;
use Phpactor202301\Phpactor\Completion\Core\Formatter\ObjectFormatter;
class VariableFormatter implements Formatter
{
    public function canFormat(object $object) : bool
    {
        return $object instanceof Variable;
    }
    public function format(ObjectFormatter $formatter, object $object) : string
    {
        \assert($object instanceof Variable);
        return $formatter->format($object->type());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\WorseReflection\\Formatter\\VariableFormatter', 'Phpactor\\Completion\\Bridge\\WorseReflection\\Formatter\\VariableFormatter', \false);
