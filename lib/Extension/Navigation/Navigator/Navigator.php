<?php

namespace Phpactor202301\Phpactor\Extension\Navigation\Navigator;

interface Navigator
{
    public function destinationsFor(string $path) : array;
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Navigation\\Navigator\\Navigator', 'Phpactor\\Extension\\Navigation\\Navigator\\Navigator', \false);
