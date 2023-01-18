<?php

namespace Phpactor202301\Phpactor\CodeTransform\Domain\Refactor;

use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
interface ChangeVisiblity
{
    public function changeVisiblity(SourceCode $source, int $offset) : SourceCode;
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Domain\\Refactor\\ChangeVisiblity', 'Phpactor\\CodeTransform\\Domain\\Refactor\\ChangeVisiblity', \false);
