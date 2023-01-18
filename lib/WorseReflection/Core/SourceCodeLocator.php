<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core;

use Phpactor202301\Phpactor\WorseReflection\Core\Exception\SourceNotFound;
interface SourceCodeLocator
{
    /**
     * @throws SourceNotFound
     */
    public function locate(Name $name) : SourceCode;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\SourceCodeLocator', 'Phpactor\\WorseReflection\\Core\\SourceCodeLocator', \false);
