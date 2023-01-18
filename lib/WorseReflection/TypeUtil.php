<?php

namespace Phpactor202301\Phpactor\WorseReflection;

use Phpactor202301\Phpactor\WorseReflection\Core\Trinary;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\BooleanLiteralType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\BooleanType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ClassType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\IntType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\Literal;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\MissingType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\MixedType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\NullType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\NumericType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ScalarType;
class TypeUtil
{
    public static function firstDefined(Type ...$types) : Type
    {
        if (empty($types)) {
            return TypeFactory::undefined();
        }
        foreach ($types as $type) {
            if ($type->isDefined()) {
                return $type;
            }
        }
        return $type;
    }
    /**
     * @return mixed
     */
    public static function valueOrNull(Type $type)
    {
        if ($type instanceof Literal) {
            return $type->value();
        }
        return null;
    }
    public static function toBool(Type $type) : BooleanType
    {
        if ($type instanceof Literal) {
            return new BooleanLiteralType((bool) $type->value());
        }
        if ($type instanceof NullType) {
            return new BooleanLiteralType(\false);
        }
        if ($type instanceof BooleanType) {
            return $type;
        }
        return new BooleanType();
    }
    public static function toNumber(Type $type) : NumericType
    {
        if ($type instanceof Literal && $type instanceof ScalarType) {
            $value = (string) $type->value();
            return TypeFactory::fromNumericString($value);
        }
        return new IntType();
    }
    public static function trinaryToBoolean(Trinary $trinary) : BooleanType
    {
        if ($trinary->isTrue()) {
            return new BooleanLiteralType(\true);
        }
        if ($trinary->isFalse()) {
            return new BooleanLiteralType(\false);
        }
        return new BooleanType();
    }
    public static function shortenClassTypes(Type $type) : Type
    {
        return $type->map(function (Type $type) {
            if ($type instanceof ClassType) {
                return TypeFactory::class($type->name()->short());
            }
            return $type;
        });
    }
    /**
     * @param Type[] $types
     */
    public static function generalTypeFromTypes(array $types) : Type
    {
        $valueType = null;
        foreach ($types as $type) {
            $type = $type->generalize();
            if ($valueType === null) {
                $valueType = $type;
                continue;
            }
            if ($valueType != $type) {
                return new MixedType();
            }
        }
        return $valueType ?: new MissingType();
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\TypeUtil', 'Phpactor\\WorseReflection\\TypeUtil', \false);
