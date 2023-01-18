<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Adapter\WorseReflection\TypeRenderer;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\FalseType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\NullType;
class WorseTypeRenderer82 extends WorseTypeRenderer81
{
    public function render(Type $type) : ?string
    {
        if ($type instanceof NullType) {
            return $type->toPhpString();
        }
        if ($type instanceof FalseType) {
            return $type->toPhpString();
        }
        return parent::render($type);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Adapter\\WorseReflection\\TypeRenderer\\WorseTypeRenderer82', 'Phpactor\\CodeBuilder\\Adapter\\WorseReflection\\TypeRenderer\\WorseTypeRenderer82', \false);
