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
use PhpactorDist\Twig\Node\Expression\ConstantExpression;
use PhpactorDist\Twig\Node\Node;
use PhpactorDist\Twig\Token;
/**
 * Imports blocks defined in another template into the current template.
 *
 *    {% extends "base.html" %}
 *
 *    {% use "blocks.html" %}
 *
 *    {% block title %}{% endblock %}
 *    {% block content %}{% endblock %}
 *
 * @see https://twig.symfony.com/doc/templates.html#horizontal-reuse for details.
 */
final class UseTokenParser extends AbstractTokenParser
{
    public function parse(Token $token)
    {
        $template = $this->parser->getExpressionParser()->parseExpression();
        $stream = $this->parser->getStream();
        if (!$template instanceof ConstantExpression) {
            throw new SyntaxError('The template references in a "use" statement must be a string.', $stream->getCurrent()->getLine(), $stream->getSourceContext());
        }
        $targets = [];
        if ($stream->nextIf('with')) {
            do {
                $name = $stream->expect(
                    /* Token::NAME_TYPE */
                    5
                )->getValue();
                $alias = $name;
                if ($stream->nextIf('as')) {
                    $alias = $stream->expect(
                        /* Token::NAME_TYPE */
                        5
                    )->getValue();
                }
                $targets[$name] = new ConstantExpression($alias, -1);
                if (!$stream->nextIf(
                    /* Token::PUNCTUATION_TYPE */
                    9,
                    ','
                )) {
                    break;
                }
            } while (\true);
        }
        $stream->expect(
            /* Token::BLOCK_END_TYPE */
            3
        );
        $this->parser->addTrait(new Node(['template' => $template, 'targets' => new Node($targets)]));
        return new Node();
    }
    public function getTag()
    {
        return 'use';
    }
}
\class_alias('PhpactorDist\\Twig\\TokenParser\\UseTokenParser', 'PhpactorDist\\Twig_TokenParser_Use');
