<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Phpactor202301\Twig\Loader;

/**
 * Empty interface for Twig 1.x compatibility.
 *
 * @deprecated since Twig 2.7, to be removed in 3.0
 */
interface ExistsLoaderInterface extends LoaderInterface
{
}
\class_alias('Phpactor202301\\Twig\\Loader\\ExistsLoaderInterface', 'Phpactor202301\\Twig_ExistsLoaderInterface');
