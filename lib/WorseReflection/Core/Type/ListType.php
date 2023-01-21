<?php

namespace Phpactor\WorseReflection\Core\Type;

use Phpactor\WorseReflection\Core\Type;
class ListType extends \Phpactor\WorseReflection\Core\Type\ArrayType
{
    public function __construct(?Type $valueType = null)
    {
        parent::__construct(new \Phpactor\WorseReflection\Core\Type\IntType(), $valueType ?: new \Phpactor\WorseReflection\Core\Type\MixedType());
    }
}
