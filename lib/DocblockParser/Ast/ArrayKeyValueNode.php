<?php

namespace Phpactor\DocblockParser\Ast;

class ArrayKeyValueNode extends \Phpactor\DocblockParser\Ast\Node
{
    protected const CHILD_NAMES = ['key', 'colon', 'type'];
    public function __construct(public ?\Phpactor\DocblockParser\Ast\Token $key, public ?\Phpactor\DocblockParser\Ast\Token $colon, public ?\Phpactor\DocblockParser\Ast\TypeNode $type)
    {
    }
}
