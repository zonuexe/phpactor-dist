<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Util;

final class TextUtil
{
    public static function lines(string $text) : array
    {
        return \preg_split("{(\r\n|\n|\r)}", $text);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Util\\TextUtil', 'Phpactor\\CodeBuilder\\Util\\TextUtil', \false);
