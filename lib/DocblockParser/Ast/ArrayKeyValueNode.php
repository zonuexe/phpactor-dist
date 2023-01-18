<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast;

class ArrayKeyValueNode extends Node
{
    protected const CHILD_NAMES = ['key', 'colon', 'type'];
    public function __construct(public ?Token $key, public ?Token $colon, public ?TypeNode $type)
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\ArrayKeyValueNode', 'Phpactor\\DocblockParser\\Ast\\ArrayKeyValueNode', \false);
