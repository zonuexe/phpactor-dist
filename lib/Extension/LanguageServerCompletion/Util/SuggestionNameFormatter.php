<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerCompletion\Util;

use Phpactor202301\Phpactor\Completion\Core\Suggestion;
class SuggestionNameFormatter
{
    public function __construct(private bool $trimLeadingDollar = \false)
    {
    }
    public function format(Suggestion $suggestion) : string
    {
        $name = $suggestion->name();
        return match ($suggestion->type()) {
            Suggestion::TYPE_VARIABLE => $this->trimLeadingDollar ? \mb_substr($name, 1) : $name,
            Suggestion::TYPE_FUNCTION, Suggestion::TYPE_METHOD => $name,
            default => $name,
        };
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerCompletion\\Util\\SuggestionNameFormatter', 'Phpactor\\Extension\\LanguageServerCompletion\\Util\\SuggestionNameFormatter', \false);
