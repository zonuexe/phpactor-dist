<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast\Value;

use Phpactor202301\Phpactor\DocblockParser\Ast\ValueNode;
use Phpactor202301\Phpactor\DocblockParser\Ast\Token;
class NullValue extends ValueNode
{
    public function __construct(private Token $null)
    {
    }
    public function null() : Token
    {
        return $this->null;
    }
    public function value()
    {
        return null;
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\Value\\NullValue', 'Phpactor\\DocblockParser\\Ast\\Value\\NullValue', \false);
