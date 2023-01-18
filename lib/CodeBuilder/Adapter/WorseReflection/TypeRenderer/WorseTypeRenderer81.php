<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Adapter\WorseReflection\TypeRenderer;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\IntersectionType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\NeverType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\StaticType;
class WorseTypeRenderer81 extends WorseTypeRenderer80
{
    public function render(Type $type) : ?string
    {
        if ($type instanceof IntersectionType) {
            return \implode('&', \array_unique(\array_map(fn(Type $t) => $this->render($t), $type->types)));
        }
        if ($type instanceof StaticType) {
            return $type->toPhpString();
        }
        if ($type instanceof NeverType) {
            return $type->toPhpString();
        }
        return parent::render($type);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Adapter\\WorseReflection\\TypeRenderer\\WorseTypeRenderer81', 'Phpactor\\CodeBuilder\\Adapter\\WorseReflection\\TypeRenderer\\WorseTypeRenderer81', \false);
