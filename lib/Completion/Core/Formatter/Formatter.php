<?php

namespace Phpactor202301\Phpactor\Completion\Core\Formatter;

interface Formatter
{
    public function canFormat(object $object) : bool;
    public function format(ObjectFormatter $formatter, object $object) : string;
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Core\\Formatter\\Formatter', 'Phpactor\\Completion\\Core\\Formatter\\Formatter', \false);
