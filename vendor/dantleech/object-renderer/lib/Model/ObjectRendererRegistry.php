<?php

namespace Phpactor202301\Phpactor\ObjectRenderer\Model;

use Phpactor202301\Phpactor\ObjectRenderer\Model\Exception\ObjectRendererNotFound;
interface ObjectRendererRegistry
{
    /**
     * @throws ObjectRendererNotFound
     */
    public function get(string $name) : ObjectRenderer;
}
\class_alias('Phpactor202301\\Phpactor\\ObjectRenderer\\Model\\ObjectRendererRegistry', 'Phpactor\\ObjectRenderer\\Model\\ObjectRendererRegistry', \false);
