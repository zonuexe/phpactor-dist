<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PhpactorDist\Twig\TokenParser;

use PhpactorDist\Twig\Error\SyntaxError;
use PhpactorDist\Twig\Node\Node;
use PhpactorDist\Twig\Parser;
use PhpactorDist\Twig\Token;
/**
 * Interface implemented by token parsers.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface TokenParserInterface
{
    /**
     * Sets the parser associated with this token parser.
     */
    public function setParser(Parser $parser);
    /**
     * Parses a token and returns a node.
     *
     * @return Node
     *
     * @throws SyntaxError
     */
    public function parse(Token $token);
    /**
     * Gets the tag name associated with this token parser.
     *
     * @return string The tag name
     */
    public function getTag();
}
\class_alias('PhpactorDist\\Twig\\TokenParser\\TokenParserInterface', 'PhpactorDist\\Twig_TokenParserInterface');
// Ensure that the aliased name is loaded to keep BC for classes implementing the typehint with the old aliased name.
\class_exists('PhpactorDist\\Twig\\Token');
\class_exists('PhpactorDist\\Twig\\Parser');
