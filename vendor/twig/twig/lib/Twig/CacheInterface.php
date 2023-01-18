<?php

namespace Phpactor202301;

use Phpactor202301\Twig\Cache\CacheInterface;
\class_exists('Phpactor202301\\Twig\\Cache\\CacheInterface');
@\trigger_error('Using the "Twig_CacheInterface" class is deprecated since Twig version 2.7, use "Twig\\Cache\\CacheInterface" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\Cache\CacheInterface" instead */
    class Twig_CacheInterface extends CacheInterface
    {
    }
}
