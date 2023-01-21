<?php

namespace Phpactor\WorseReflection\Core;

interface TypeResolver
{
    public function resolve(\Phpactor\WorseReflection\Core\Type $type) : \Phpactor\WorseReflection\Core\Type;
}
