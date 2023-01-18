<?php

namespace Phpactor202301\Phpactor\Extension\Core\Console\Formatter;

class Highlight
{
    public static function highlightAtCol(string $line, string $subject, int $col, bool $ansi)
    {
        $leftBracket = '⟶';
        $rightBracket = '⟵';
        if ($ansi) {
            $leftBracket = '<highlight>';
            $rightBracket = '</>';
        }
        return \sprintf('%s%s%s%s%s', \substr($line, 0, $col), $leftBracket, $subject, $rightBracket, \substr($line, $col + \strlen($subject)));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Core\\Console\\Formatter\\Highlight', 'Phpactor\\Extension\\Core\\Console\\Formatter\\Highlight', \false);
