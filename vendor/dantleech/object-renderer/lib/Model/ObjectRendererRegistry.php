<?php

namespace Phpactor\ObjectRenderer\Model;

use Phpactor\ObjectRenderer\Model\Exception\ObjectRendererNotFound;
interface ObjectRendererRegistry
{
    /**
     * @throws ObjectRendererNotFound
     */
    public function get(string $name) : \Phpactor\ObjectRenderer\Model\ObjectRenderer;
}
