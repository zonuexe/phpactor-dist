<?php

namespace Phpactor202301;

use Phpactor202301\Twig\Error\LoaderError;
\class_exists('Phpactor202301\\Twig\\Error\\LoaderError');
@\trigger_error('Using the "Twig_Error_Loader" class is deprecated since Twig version 2.7, use "Twig\\Error\\LoaderError" instead.', \E_USER_DEPRECATED);
if (\false) {
    /** @deprecated since Twig 2.7, use "Twig\Error\LoaderError" instead */
    class Twig_Error_Loader extends LoaderError
    {
    }
}
