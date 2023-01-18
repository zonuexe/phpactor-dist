<?php

namespace Phpactor202301\Phpactor\Completion\Core\Util;

use RuntimeException;
use function preg_last_error_msg;
class OffsetHelper
{
    public static function lastNonWhitespaceCharacterOffset(string $input) : int
    {
        $source = \preg_replace('/[ \\t\\x0d\\n\\r\\f]+$/u', '', $input);
        if (null === $source) {
            throw new RuntimeException(\sprintf('preg_replace could not parse string (size %s): %s', \strlen($input), preg_last_error_msg()));
        }
        return \mb_strlen($source);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Core\\Util\\OffsetHelper', 'Phpactor\\Completion\\Core\\Util\\OffsetHelper', \false);
