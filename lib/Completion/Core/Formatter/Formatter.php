<?php

namespace Phpactor\Completion\Core\Formatter;

interface Formatter
{
    public function canFormat(object $object) : bool;
    public function format(\Phpactor\Completion\Core\Formatter\ObjectFormatter $formatter, object $object) : string;
}
