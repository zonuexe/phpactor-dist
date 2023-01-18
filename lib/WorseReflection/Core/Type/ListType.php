<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
class ListType extends ArrayType
{
    public function __construct(?Type $valueType = null)
    {
        parent::__construct(new IntType(), $valueType ?: new MixedType());
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\ListType', 'Phpactor\\WorseReflection\\Core\\Type\\ListType', \false);
