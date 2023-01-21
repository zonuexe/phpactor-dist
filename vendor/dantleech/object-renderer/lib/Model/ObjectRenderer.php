<?php

namespace Phpactor\ObjectRenderer\Model;

interface ObjectRenderer
{
    public function render(object $object) : string;
}
