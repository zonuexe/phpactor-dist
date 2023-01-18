<?php

namespace Phpactor202301;

class UnitEnumCase
{
    public string $name;
}
\class_alias('Phpactor202301\\UnitEnumCase', 'UnitEnumCase', \false);
class BackedEnumCase extends UnitEnumCase
{
    /** @var int|string */
    public $value;
}
\class_alias('Phpactor202301\\BackedEnumCase', 'BackedEnumCase', \false);
interface UnitEnum
{
    /**
     * @return UnitEnumCase[]
     */
    public static function cases() : array;
}
\class_alias('Phpactor202301\\UnitEnum', 'UnitEnum', \false);
interface BackedEnum extends \UnitEnum
{
    /**
     * @return BackedEnumCase[]
     */
    public static function cases() : array;
    /**
     * @param int|string $value
     * @return static
     */
    public static function from($value) : static;
    /**
     * @param int|string $value
     * @return static|null
     */
    public static function tryFrom($value) : ?static;
}
\class_alias('Phpactor202301\\BackedEnum', 'BackedEnum', \false);
