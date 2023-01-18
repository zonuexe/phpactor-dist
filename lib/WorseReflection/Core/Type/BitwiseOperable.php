<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
interface BitwiseOperable
{
    public function shiftRight(Type $right) : Type;
    public function shiftLeft(Type $right) : Type;
    public function bitwiseXor(Type $right) : Type;
    public function bitwiseOr(Type $right) : Type;
    public function bitwiseAnd(Type $right) : Type;
    public function bitwiseNot() : Type;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\BitwiseOperable', 'Phpactor\\WorseReflection\\Core\\Type\\BitwiseOperable', \false);
