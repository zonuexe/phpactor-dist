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

use PhpactorDist\Twig\Parser;
/**
 * Base class for all token parsers.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class AbstractTokenParser implements TokenParserInterface
{
    /**
     * @var Parser
     */
    protected $parser;
    public function setParser(Parser $parser)
    {
        $this->parser = $parser;
    }
}
\class_alias('PhpactorDist\\Twig\\TokenParser\\AbstractTokenParser', 'PhpactorDist\\Twig_TokenParser');
