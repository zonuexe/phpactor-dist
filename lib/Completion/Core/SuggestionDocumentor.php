<?php

namespace Phpactor202301\Phpactor\Completion\Core;

use Closure;
interface SuggestionDocumentor
{
    public function document(Suggestion $suggestion) : Closure;
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Core\\SuggestionDocumentor', 'Phpactor\\Completion\\Core\\SuggestionDocumentor', \false);
