<?php

namespace Phpactor202301\Phpactor\Extension\Symfony\Model;

interface SymfonyContainerInspector
{
    /**
     * @return SymfonyContainerService[]
     */
    public function services() : array;
    /**
     * @return SymfonyContainerParameter[]
     */
    public function parameters() : array;
    public function service(string $id) : ?SymfonyContainerService;
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Symfony\\Model\\SymfonyContainerInspector', 'Phpactor\\Extension\\Symfony\\Model\\SymfonyContainerInspector', \false);
