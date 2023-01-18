<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast;

abstract class ValueNode extends Node
{
    /**
     * @return mixed
     */
    public abstract function value();
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\ValueNode', 'Phpactor\\DocblockParser\\Ast\\ValueNode', \false);
