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

use PhpactorDist\Twig\Node\FlushNode;
use PhpactorDist\Twig\Token;
/**
 * Flushes the output to the client.
 *
 * @see flush()
 */
final class FlushTokenParser extends AbstractTokenParser
{
    public function parse(Token $token)
    {
        $this->parser->getStream()->expect(
            /* Token::BLOCK_END_TYPE */
            3
        );
        return new FlushNode($token->getLine(), $this->getTag());
    }
    public function getTag()
    {
        return 'flush';
    }
}
\class_alias('PhpactorDist\\Twig\\TokenParser\\FlushTokenParser', 'PhpactorDist\\Twig_TokenParser_Flush');
