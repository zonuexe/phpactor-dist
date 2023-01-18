<?php

namespace Phpactor202301\Phpactor\Extension\Symfony\Model;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
class SymfonyContainerService
{
    public function __construct(public string $id, public Type $type)
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Symfony\\Model\\SymfonyContainerService', 'Phpactor\\Extension\\Symfony\\Model\\SymfonyContainerService', \false);
