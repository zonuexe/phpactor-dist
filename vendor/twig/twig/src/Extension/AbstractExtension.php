<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PhpactorDist\Twig\Extension;

abstract class AbstractExtension implements ExtensionInterface
{
    public function getTokenParsers()
    {
        return [];
    }
    public function getNodeVisitors()
    {
        return [];
    }
    public function getFilters()
    {
        return [];
    }
    public function getTests()
    {
        return [];
    }
    public function getFunctions()
    {
        return [];
    }
    public function getOperators()
    {
        return [];
    }
}
\class_alias('PhpactorDist\\Twig\\Extension\\AbstractExtension', 'PhpactorDist\\Twig_Extension');
