<?php

namespace Phpactor202301;

class ClassOne
{
    public function build()
    {
        return new self();
    }
}
\class_alias('Phpactor202301\\ClassOne', 'ClassOne', \false);
