<?php

namespace Phpactor202301\Phpactor\CodeTransform\Domain\Helper\MissingMethodFinder;

use Phpactor202301\Phpactor\TextDocument\ByteOffsetRange;
class MissingMethod
{
    public function __construct(private string $name, public ByteOffsetRange $range)
    {
    }
    public function range() : ByteOffsetRange
    {
        return $this->range;
    }
    public function name() : string
    {
        return $this->name;
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Domain\\Helper\\MissingMethodFinder\\MissingMethod', 'Phpactor\\CodeTransform\\Domain\\Helper\\MissingMethodFinder\\MissingMethod', \false);
