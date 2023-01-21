<?php

namespace Phpactor\Completion\Core;

use Closure;
interface SuggestionDocumentor
{
    public function document(\Phpactor\Completion\Core\Suggestion $suggestion) : Closure;
}
