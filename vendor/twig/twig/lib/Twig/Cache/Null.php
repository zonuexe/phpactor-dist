<?php

namespace PhpactorDist;

use PhpactorDist\Twig\Cache\NullCache;
\class_exists('PhpactorDist\\Twig\\Cache\\NullCache');
@\trigger_error('Using the "Twig_Cache_Null" class is deprecated since Twig version 2.7, use "Twig\\Cache\\NullCache" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\Cache\NullCache" instead */
    class Twig_Cache_Null extends NullCache
    {
    }
}
