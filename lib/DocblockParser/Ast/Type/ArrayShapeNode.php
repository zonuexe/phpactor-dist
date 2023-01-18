<?php

namespace Phpactor202301\Phpactor\DocblockParser\Ast\Type;

use Phpactor202301\Phpactor\DocblockParser\Ast\ArrayKeyValueList;
use Phpactor202301\Phpactor\DocblockParser\Ast\Token;
use Phpactor202301\Phpactor\DocblockParser\Ast\TypeNode;
class ArrayShapeNode extends TypeNode
{
    protected const CHILD_NAMES = ['open', 'arrayKeyValueList', 'close'];
    public function __construct(public Token $open, public ArrayKeyValueList $arrayKeyValueList, public ?Token $close)
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Ast\\Type\\ArrayShapeNode', 'Phpactor\\DocblockParser\\Ast\\Type\\ArrayShapeNode', \false);
