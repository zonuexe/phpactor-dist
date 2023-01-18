<?php

namespace Phpactor202301\Phpactor\FilePathResolver\Filter;

use Phpactor202301\Phpactor\FilePathResolver\Expanders;
use Phpactor202301\Phpactor\FilePathResolver\Filter;
class TokenExpandingFilter implements Filter
{
    public function __construct(private Expanders $expanders)
    {
    }
    public function apply(string $path) : string
    {
        if (!\str_contains($path, '%')) {
            return $path;
        }
        if (!\preg_match_all('{%(.*?)%}', $path, $matches)) {
            return $path;
        }
        foreach ($matches[1] as $match) {
            $expander = $this->expanders->get($match);
            $path = \str_replace('%' . $match . '%', $expander->replacementValue(), $path);
        }
        return $path;
    }
}
\class_alias('Phpactor202301\\Phpactor\\FilePathResolver\\Filter\\TokenExpandingFilter', 'Phpactor\\FilePathResolver\\Filter\\TokenExpandingFilter', \false);
