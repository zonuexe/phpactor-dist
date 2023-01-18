<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Adapter\TolerantParser;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\QualifiedName;
use Phpactor202301\Microsoft\PhpParser\Token;
use Phpactor202301\Phpactor\CodeBuilder\Util\TextFormat;
use Phpactor202301\Phpactor\TextDocument\TextEdit;
use Phpactor202301\Phpactor\TextDocument\TextEdits;
class Edits
{
    /**
     * @var array<TextEdit>
     */
    private array $edits = [];
    private TextFormat $format;
    public function __construct(TextFormat $format = null)
    {
        $this->format = $format ?: new TextFormat();
    }
    /**
     * @param Node|Token $node
     */
    public function remove($node) : void
    {
        $this->edits[] = TextEdit::create($node->getFullStartPosition(), $node->getFullWidth(), '');
    }
    /**
     * @param Node|Token $node
     */
    public function before($node, string $text) : void
    {
        $this->edits[] = TextEdit::create($node->getStartPosition(), 0, $text);
    }
    /**
     * @param Node|Token $node
     */
    public function after($node, string $text) : void
    {
        $this->edits[] = TextEdit::create($node->getEndPosition(), 0, $text);
    }
    /**
     * @param Node|Token|QualifiedName $node
     */
    public function replace($node, string $text) : void
    {
        $this->edits[] = TextEdit::create($node->getFullStartPosition(), $node->getFullWidth(), $text);
    }
    public function textEdits() : TextEdits
    {
        return TextEdits::fromTextEdits($this->edits);
    }
    public function add(TextEdit $textEdit) : void
    {
        $this->edits[] = $textEdit;
    }
    public function indent(string $string, int $level) : string
    {
        return $this->format->indent($string, $level);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Adapter\\TolerantParser\\Edits', 'Phpactor\\CodeBuilder\\Adapter\\TolerantParser\\Edits', \false);
