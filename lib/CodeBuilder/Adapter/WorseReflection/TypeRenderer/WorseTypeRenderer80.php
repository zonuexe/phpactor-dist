<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Adapter\WorseReflection\TypeRenderer;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\MixedType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\UnionType;
class WorseTypeRenderer80 extends WorseTypeRenderer74
{
    public function render(Type $type) : ?string
    {
        if ($type instanceof UnionType) {
            return \implode('|', \array_unique(\array_map(fn(Type $t) => $this->render($t), $type->types)));
        }
        if ($type instanceof MixedType) {
            return $type->toPhpString();
        }
        return parent::render($type);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Adapter\\WorseReflection\\TypeRenderer\\WorseTypeRenderer80', 'Phpactor\\CodeBuilder\\Adapter\\WorseReflection\\TypeRenderer\\WorseTypeRenderer80', \false);