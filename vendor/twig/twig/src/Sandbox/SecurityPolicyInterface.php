<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PhpactorDist\Twig\Sandbox;

/**
 * Interface that all security policy classes must implements.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface SecurityPolicyInterface
{
    /**
     * @param string[] $tags
     * @param string[] $filters
     * @param string[] $functions
     *
     * @throws SecurityError
     */
    public function checkSecurity($tags, $filters, $functions);
    /**
     * @param object $obj
     * @param string $method
     *
     * @throws SecurityNotAllowedMethodError
     */
    public function checkMethodAllowed($obj, $method);
    /**
     * @param object $obj
     * @param string $property
     *
     * @throws SecurityNotAllowedPropertyError
     */
    public function checkPropertyAllowed($obj, $property);
}
\class_alias('PhpactorDist\\Twig\\Sandbox\\SecurityPolicyInterface', 'PhpactorDist\\Twig_Sandbox_SecurityPolicyInterface');
