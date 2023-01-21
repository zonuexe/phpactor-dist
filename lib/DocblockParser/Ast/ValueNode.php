<?php

namespace Phpactor\DocblockParser\Ast;

abstract class ValueNode extends \Phpactor\DocblockParser\Ast\Node
{
    /**
     * @return mixed
     */
    public abstract function value();
}
