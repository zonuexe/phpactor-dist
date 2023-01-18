<?php

namespace Phpactor202301\Phpactor\CodeTransform\Domain\Refactor;

use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
interface RenameVariable
{
    const SCOPE_LOCAL = 'local';
    const SCOPE_FILE = 'file';
    public function renameVariable(SourceCode $source, int $offset, string $newName, string $scope = RenameVariable::SCOPE_FILE) : SourceCode;
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Domain\\Refactor\\RenameVariable', 'Phpactor\\CodeTransform\\Domain\\Refactor\\RenameVariable', \false);
