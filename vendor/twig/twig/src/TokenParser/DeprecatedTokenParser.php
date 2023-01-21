<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Phpactor202301\Twig\TokenParser;

use Phpactor202301\Twig\Node\DeprecatedNode;
use Phpactor202301\Twig\Token;
/**
 * Deprecates a section of a template.
 *
 *    {% deprecated 'The "base.twig" template is deprecated, use "layout.twig" instead.' %}
 *    {% extends 'layout.html.twig' %}
 *
 * @author Yonel Ceruto <yonelceruto@gmail.com>
 *
 * @final
 */
class DeprecatedTokenParser extends AbstractTokenParser
{
    public function parse(Token $token)
    {
        $expr = $this->parser->getExpressionParser()->parseExpression();
        $this->parser->getStream()->expect(Token::BLOCK_END_TYPE);
        return new DeprecatedNode($expr, $token->getLine(), $this->getTag());
    }
    public function getTag()
    {
        return 'deprecated';
    }
}
\class_alias('Phpactor202301\\Twig\\TokenParser\\DeprecatedTokenParser', 'Phpactor202301\\Twig_TokenParser_Deprecated');
