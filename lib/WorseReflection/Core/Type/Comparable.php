<?php

namespace Phpactor\WorseReflection\Core\Type;

use Phpactor\WorseReflection\Core\Type;
interface Comparable
{
    public function identical(Type $right) : \Phpactor\WorseReflection\Core\Type\BooleanType;
    public function greaterThan(Type $right) : \Phpactor\WorseReflection\Core\Type\BooleanType;
    public function greaterThanEqual(Type $right) : \Phpactor\WorseReflection\Core\Type\BooleanType;
    public function lessThan(Type $right) : \Phpactor\WorseReflection\Core\Type\BooleanType;
    public function notEqual(Type $right) : \Phpactor\WorseReflection\Core\Type\BooleanType;
    public function lessThanEqual(Type $right) : \Phpactor\WorseReflection\Core\Type\BooleanType;
    public function equal(Type $right) : \Phpactor\WorseReflection\Core\Type\BooleanType;
    public function notIdentical(Type $type) : \Phpactor\WorseReflection\Core\Type\BooleanType;
}
