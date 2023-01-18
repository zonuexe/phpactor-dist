<?php

namespace Phpactor202301;

/**
 * @since 8.1
 */
class IntlDatePatternGenerator
{
    public function __construct(?string $locale = null)
    {
    }
    public static function create(?string $locale = null) : ?\IntlDatePatternGenerator
    {
    }
    public function getBestPattern(string $skeleton) : string|false
    {
    }
}
/**
 * @since 8.1
 */
\class_alias('Phpactor202301\\IntlDatePatternGenerator', 'IntlDatePatternGenerator', \false);
