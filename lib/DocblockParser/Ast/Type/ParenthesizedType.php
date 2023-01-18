<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast\Type;

use Phpactor202301\Phpactor\DocblockParser\Ast\Token;
use Phpactor202301\Phpactor\DocblockParser\Ast\TypeNode;
class ParenthesizedType extends TypeNode
{
    protected const CHILD_NAMES = ['open', 'node', 'closed'];
    public function __construct(public Token $open, public ?TypeNode $node, public ?Token $closed)
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\Type\\ParenthesizedType', 'Phpactor\\DocblockParser\\Ast\\Type\\ParenthesizedType', \false);
