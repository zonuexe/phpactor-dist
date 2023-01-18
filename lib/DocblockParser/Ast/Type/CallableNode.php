<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast\Type;

use Phpactor202301\Phpactor\DocblockParser\Ast\TypeList;
use Phpactor202301\Phpactor\DocblockParser\Ast\TypeNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\Token;
class CallableNode extends TypeNode
{
    protected const CHILD_NAMES = ['name', 'open', 'parameters', 'close', 'colon', 'type'];
    public function __construct(public ?Token $name, public ?Token $open, public ?TypeList $parameters, public ?Token $close, public ?Token $colon, public ?TypeNode $type)
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\Type\\CallableNode', 'Phpactor\\DocblockParser\\Ast\\Type\\CallableNode', \false);
