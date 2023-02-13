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
use PhpactorDist\Twig\Node\AutoEscapeNode;
use PhpactorDist\Twig\Node\Expression\ConstantExpression;
use PhpactorDist\Twig\Token;
/**
 * Marks a section of a template to be escaped or not.
 */
final class AutoEscapeTokenParser extends AbstractTokenParser
{
    public function parse(Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        if ($stream->test(
            /* Token::BLOCK_END_TYPE */
            3
        )) {
            $value = 'html';
        } else {
            $expr = $this->parser->getExpressionParser()->parseExpression();
            if (!$expr instanceof ConstantExpression) {
                throw new SyntaxError('An escaping strategy must be a string or false.', $stream->getCurrent()->getLine(), $stream->getSourceContext());
            }
            $value = $expr->getAttribute('value');
        }
        $stream->expect(
            /* Token::BLOCK_END_TYPE */
            3
        );
        $body = $this->parser->subparse([$this, 'decideBlockEnd'], \true);
        $stream->expect(
            /* Token::BLOCK_END_TYPE */
            3
        );
        return new AutoEscapeNode($value, $body, $lineno, $this->getTag());
    }
    public function decideBlockEnd(Token $token)
    {
        return $token->test('endautoescape');
    }
    public function getTag()
    {
        return 'autoescape';
    }
}
\class_alias('PhpactorDist\\Twig\\TokenParser\\AutoEscapeTokenParser', 'PhpactorDist\\Twig_TokenParser_AutoEscape');
