<?php

namespace Phpactor202301\Phpactor\DocblockParser\Tests\Unit;

use Generator;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\DocblockParser\Ast\Docblock;
use Phpactor202301\Phpactor\DocblockParser\Ast\Node;
use Phpactor202301\Phpactor\DocblockParser\Lexer;
use Phpactor202301\Phpactor\DocblockParser\Parser;
use Phpactor202301\Phpactor\DocblockParser\Ast\Token;
class ParserTest extends TestCase
{
    /**
     * @dataProvider provideParse
     */
    public function testParse(string $text, Node $expected) : void
    {
        $node = (new Parser())->parse((new Lexer())->lex($text));
        self::assertEquals($expected, $node);
    }
    /**
     * @return Generator<mixed>
     */
    public function provideParse() : Generator
    {
        (yield ['/** */', new Docblock([new Token(0, Token::T_PHPDOC_OPEN, '/**'), new Token(3, Token::T_WHITESPACE, ' '), new Token(4, Token::T_PHPDOC_CLOSE, '*/')])]);
        (yield ['/** Hello */', new Docblock([new Token(0, Token::T_PHPDOC_OPEN, '/**'), new Token(3, Token::T_WHITESPACE, ' '), new Token(4, Token::T_LABEL, 'Hello'), new Token(9, Token::T_WHITESPACE, ' '), new Token(10, Token::T_PHPDOC_CLOSE, '*/')])]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Tests\\Unit\\ParserTest', 'Phpactor\\DocblockParser\\Tests\\Unit\\ParserTest', \false);
