<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\Formatter;

use Phpactor202301\Phpactor\Completion\Core\Formatter\Formatter;
use Phpactor202301\Phpactor\Completion\Core\Formatter\ObjectFormatter;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionTrait;
class TraitFormatter implements Formatter
{
    public function canFormat(object $object) : bool
    {
        return $object instanceof ReflectionTrait;
    }
    public function format(ObjectFormatter $formatter, object $object) : string
    {
        \assert($object instanceof ReflectionTrait);
        $info = [];
        if ($object->deprecation()->isDefined()) {
            $info[] = '⚠ ';
        }
        $info[] = \sprintf('%s (trait)', $object->name()->full());
        return \implode('', $info);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\WorseReflection\\Formatter\\TraitFormatter', 'Phpactor\\Completion\\Bridge\\WorseReflection\\Formatter\\TraitFormatter', \false);
