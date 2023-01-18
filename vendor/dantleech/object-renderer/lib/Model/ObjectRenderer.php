<?php

namespace Phpactor202301\Phpactor\ObjectRenderer\Model;

interface ObjectRenderer
{
    public function render(object $object) : string;
}
\class_alias('Phpactor202301\\Phpactor\\ObjectRenderer\\Model\\ObjectRenderer', 'Phpactor\\ObjectRenderer\\Model\\ObjectRenderer', \false);
