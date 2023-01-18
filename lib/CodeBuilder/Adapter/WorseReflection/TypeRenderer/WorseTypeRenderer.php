<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Adapter\WorseReflection\TypeRenderer;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
interface WorseTypeRenderer
{
    public function render(Type $type) : ?string;
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Adapter\\WorseReflection\\TypeRenderer\\WorseTypeRenderer', 'Phpactor\\CodeBuilder\\Adapter\\WorseReflection\\TypeRenderer\\WorseTypeRenderer', \false);
