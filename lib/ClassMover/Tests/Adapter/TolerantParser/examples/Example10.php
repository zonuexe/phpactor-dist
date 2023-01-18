<?php

namespace Phpactor202301;

use Phpactor202301\Foobar\Example as BadExample;
class ClassOne
{
    public function build() : BadExample
    {
    }
}
\class_alias('Phpactor202301\\ClassOne', 'ClassOne', \false);
