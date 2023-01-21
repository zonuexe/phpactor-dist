<?php

namespace Phpactor\WorseReflection\Core;

use Phpactor\WorseReflection\Core\Exception\SourceNotFound;
interface SourceCodeLocator
{
    /**
     * @throws SourceNotFound
     */
    public function locate(\Phpactor\WorseReflection\Core\Name $name) : \Phpactor\WorseReflection\Core\SourceCode;
}
