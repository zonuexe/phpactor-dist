<?php

namespace Phpactor202301\Phpactor\Extension\Debug\Model;

interface Documentor
{
    public function document(string $commandName = '') : string;
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Debug\\Model\\Documentor', 'Phpactor\\Extension\\Debug\\Model\\Documentor', \false);
