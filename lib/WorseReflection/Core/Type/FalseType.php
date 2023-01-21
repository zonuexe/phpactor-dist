<?php

namespace Phpactor\WorseReflection\Core\Type;

class FalseType extends \Phpactor\WorseReflection\Core\Type\BooleanLiteralType
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
