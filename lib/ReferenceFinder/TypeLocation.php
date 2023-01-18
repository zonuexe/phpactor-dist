<?php

namespace Phpactor202301\Phpactor\ReferenceFinder;

use Phpactor202301\Phpactor\TextDocument\Location;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
class TypeLocation
{
    public function __construct(private Type $type, private Location $location)
    {
    }
    public function type() : Type
    {
        return $this->type;
    }
    public function location() : Location
    {
        return $this->location;
    }
}
\class_alias('Phpactor202301\\Phpactor\\ReferenceFinder\\TypeLocation', 'Phpactor\\ReferenceFinder\\TypeLocation', \false);
