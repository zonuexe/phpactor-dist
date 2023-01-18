<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\TraitImport;

use Phpactor202301\Phpactor\WorseReflection\Core\Visibility;
class TraitAlias
{
    public function __construct(private string $originalName, private ?Visibility $visiblity, private string $newName)
    {
    }
    public function originalName() : string
    {
        return $this->originalName;
    }
    public function visiblity(Visibility $default = null) : Visibility
    {
        return ($this->visiblity ?: $default) ?: Visibility::public();
    }
    public function newName() : string
    {
        return $this->newName;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\TraitImport\\TraitAlias', 'Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\TraitImport\\TraitAlias', \false);
