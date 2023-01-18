<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\Phpactor\DocblockParser;

use Phpactor202301\Phpactor\DocblockParser\Ast\Docblock as ParserDocblock;
use Phpactor202301\Phpactor\WorseReflection\Core\DocBlock\DocBlock;
use Phpactor202301\Phpactor\WorseReflection\Core\DocBlock\DocBlockFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\DocBlock\PlainDocblock;
use Phpactor202301\Phpactor\DocblockParser\Lexer;
use Phpactor202301\Phpactor\DocblockParser\Parser;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionScope;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
class DocblockParserFactory implements DocBlockFactory
{
    const SUPPORTED_TAGS = ['property', 'var', 'param', 'return', 'method', 'deprecated', 'extends', 'implements', 'template', 'template-covariant', 'template-extends', 'mixin', 'throws'];
    private Lexer $lexer;
    private Parser $parser;
    public function __construct(private Reflector $reflector, ?Lexer $lexer = null, ?Parser $parser = null)
    {
        $this->lexer = $lexer ?: new Lexer();
        $this->parser = $parser ?: new Parser();
    }
    public function create(string $docblock, ReflectionScope $scope) : DocBlock
    {
        if (empty(\trim($docblock))) {
            return new PlainDocblock();
        }
        // if no supported tags in the docblock, do not parse it
        if (0 === \preg_match(\sprintf('{@((psalm|phpstan|phan)-)?(%s)}', \implode('|', self::SUPPORTED_TAGS)), $docblock, $matches)) {
            return new PlainDocblock($docblock);
        }
        $node = $this->parser->parse($this->lexer->lex($docblock));
        \assert($node instanceof ParserDocblock);
        return new ParsedDocblock($node, new TypeConverter($this->reflector, $scope), $docblock);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\Phpactor\\DocblockParser\\DocblockParserFactory', 'Phpactor\\WorseReflection\\Bridge\\Phpactor\\DocblockParser\\DocblockParserFactory', \false);
