<?php

namespace Phpactor202301\Phpactor\CodeTransform\Domain\Helper;

use Phpactor202301\Phpactor\CodeTransform\Domain\Helper\MissingMethodFinder\MissingMethod;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
interface MissingMethodFinder
{
    /**
     * @return MissingMethod[]
     */
    public function find(TextDocument $sourceCode) : array;
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Domain\\Helper\\MissingMethodFinder', 'Phpactor\\CodeTransform\\Domain\\Helper\\MissingMethodFinder', \false);
