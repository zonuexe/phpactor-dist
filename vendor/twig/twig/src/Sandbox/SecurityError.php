<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Phpactor202301\Twig\Sandbox;

use Phpactor202301\Twig\Error\Error;
/**
 * Exception thrown when a security error occurs at runtime.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class SecurityError extends Error
{
}
\class_alias('Phpactor202301\\Twig\\Sandbox\\SecurityError', 'Phpactor202301\\Twig_Sandbox_SecurityError');
