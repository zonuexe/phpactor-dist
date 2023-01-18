<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
interface Comparable
{
    public function identical(Type $right) : BooleanType;
    public function greaterThan(Type $right) : BooleanType;
    public function greaterThanEqual(Type $right) : BooleanType;
    public function lessThan(Type $right) : BooleanType;
    public function notEqual(Type $right) : BooleanType;
    public function lessThanEqual(Type $right) : BooleanType;
    public function equal(Type $right) : BooleanType;
    public function notIdentical(Type $type) : BooleanType;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\Comparable', 'Phpactor\\WorseReflection\\Core\\Type\\Comparable', \false);
