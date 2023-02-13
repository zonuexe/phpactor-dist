<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 * (c) Armin Ronacher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PhpactorDist\Twig\Node\Expression;

use PhpactorDist\Twig\Node\Node;
/**
 * Abstract class for all nodes that represents an expression.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class AbstractExpression extends Node
{
}
\class_alias('PhpactorDist\\Twig\\Node\\Expression\\AbstractExpression', 'PhpactorDist\\Twig_Node_Expression');
