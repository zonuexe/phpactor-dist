<?php

namespace Phpactor202301;

use Phpactor202301\Twig\Source;
\class_exists('Phpactor202301\\Twig\\Source');
@\trigger_error('Using the "Twig_Source" class is deprecated since Twig version 2.7, use "Twig\\Source" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\Source" instead */
    class Twig_Source extends Source
    {
    }
}
