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

use PhpactorDist\Twig\Node\BlockNode;
use PhpactorDist\Twig\Node\Expression\BlockReferenceExpression;
use PhpactorDist\Twig\Node\Expression\ConstantExpression;
use PhpactorDist\Twig\Node\PrintNode;
use PhpactorDist\Twig\Token;
/**
 * Filters a section of a template by applying filters.
 *
 *   {% filter upper %}
 *      This text becomes uppercase
 *   {% endfilter %}
 *
 * @deprecated since Twig 2.9, to be removed in 3.0 (use the "apply" tag instead)
 */
final class FilterTokenParser extends AbstractTokenParser
{
    public function parse(Token $token)
    {
        $stream = $this->parser->getStream();
        $lineno = $token->getLine();
        @\trigger_error(\sprintf('The "filter" tag in "%s" at line %d is deprecated since Twig 2.9, use the "apply" tag instead.', $stream->getSourceContext()->getName(), $lineno), \E_USER_DEPRECATED);
        $name = $this->parser->getVarName();
        $ref = new BlockReferenceExpression(new ConstantExpression($name, $lineno), null, $lineno, $this->getTag());
        $filter = $this->parser->getExpressionParser()->parseFilterExpressionRaw($ref, $this->getTag());
        $stream->expect(
            /* Token::BLOCK_END_TYPE */
            3
        );
        $body = $this->parser->subparse([$this, 'decideBlockEnd'], \true);
        $stream->expect(
            /* Token::BLOCK_END_TYPE */
            3
        );
        $block = new BlockNode($name, $body, $lineno);
        $this->parser->setBlock($name, $block);
        return new PrintNode($filter, $lineno, $this->getTag());
    }
    public function decideBlockEnd(Token $token)
    {
        return $token->test('endfilter');
    }
    public function getTag()
    {
        return 'filter';
    }
}
\class_alias('PhpactorDist\\Twig\\TokenParser\\FilterTokenParser', 'PhpactorDist\\Twig_TokenParser_Filter');
