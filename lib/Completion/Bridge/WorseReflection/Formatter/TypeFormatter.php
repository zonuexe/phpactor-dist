<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\WorseReflection\Formatter;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\Completion\Core\Formatter\Formatter;
use Phpactor202301\Phpactor\Completion\Core\Formatter\ObjectFormatter;
use Phpactor202301\Phpactor\WorseReflection\TypeUtil;
class TypeFormatter implements Formatter
{
    public function canFormat(object $object) : bool
    {
        return $object instanceof Type;
    }
    public function format(ObjectFormatter $formatter, object $type) : string
    {
        \assert($type instanceof Type);
        return TypeUtil::shortenClassTypes($type);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\WorseReflection\\Formatter\\TypeFormatter', 'Phpactor\\Completion\\Bridge\\WorseReflection\\Formatter\\TypeFormatter', \false);
