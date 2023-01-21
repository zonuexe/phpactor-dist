<?php

namespace Phpactor\WorseReflection\Core\Type;

use Phpactor\WorseReflection\Core\Type;
use Phpactor\WorseReflection\Core\TypeFactory;
use RuntimeException;
trait ComparableTrait
{
    public function identical(Type $right) : \Phpactor\WorseReflection\Core\Type\BooleanType
    {
        return $this->compare($right, '===');
    }
    public function greaterThan(Type $right) : \Phpactor\WorseReflection\Core\Type\BooleanType
    {
        return $this->compare($right, '>');
    }
    public function greaterThanEqual(Type $right) : \Phpactor\WorseReflection\Core\Type\BooleanType
    {
        return $this->compare($right, '>=');
    }
    public function lessThan(Type $right) : \Phpactor\WorseReflection\Core\Type\BooleanType
    {
        return $this->compare($right, '<');
    }
    public function notEqual(Type $right) : \Phpactor\WorseReflection\Core\Type\BooleanType
    {
        return $this->compare($right, '!=');
    }
    public function lessThanEqual(Type $right) : \Phpactor\WorseReflection\Core\Type\BooleanType
    {
        return $this->compare($right, '<=');
    }
    public function equal(Type $right) : \Phpactor\WorseReflection\Core\Type\BooleanType
    {
        return $this->compare($right, '==');
    }
    public function notIdentical(Type $right) : \Phpactor\WorseReflection\Core\Type\BooleanType
    {
        return $this->compare($right, '!==');
    }
    private function compare(Type $right, string $operator) : \Phpactor\WorseReflection\Core\Type\BooleanType
    {
        if (!$this instanceof \Phpactor\WorseReflection\Core\Type\Literal) {
            return TypeFactory::bool();
        }
        if ($right instanceof \Phpactor\WorseReflection\Core\Type\ScalarType && $right instanceof \Phpactor\WorseReflection\Core\Type\Literal) {
            return TypeFactory::boolLiteral($this->doCompare($this->value(), $right->value(), $operator));
        }
        return TypeFactory::bool();
    }
    /**
     * @param mixed $left
     * @param mixed $right
     */
    private function doCompare($left, $right, string $operator) : bool
    {
        if ($operator === '===') {
            return $left === $right;
        }
        if ($operator === '==') {
            return $left == $right;
        }
        if ($operator === '!==') {
            return $left !== $right;
        }
        if ($operator === '!=') {
            return $left != $right;
        }
        if ($operator === '>') {
            return $left > $right;
        }
        if ($operator === '>=') {
            return $left >= $right;
        }
        if ($operator === '<') {
            return $left < $right;
        }
        if ($operator === '<=') {
            return $left <= $right;
        }
        throw new RuntimeException(\sprintf('Do not know how to handle operator "%s"', $operator));
    }
}
