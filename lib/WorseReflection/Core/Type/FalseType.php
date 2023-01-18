<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

class FalseType extends BooleanLiteralType
{
    public function __construct()
    {
        parent::__construct(\false);
    }
    public function toPhpString() : string
    {
        return 'false';
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\FalseType', 'Phpactor\\WorseReflection\\Core\\Type\\FalseType', \false);
