<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator;

use Phpactor202301\Phpactor\WorseReflection\Core\Exception\SourceNotFound;
use Phpactor202301\Phpactor\WorseReflection\Core\Name;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator;
class NullSourceLocator implements SourceCodeLocator
{
    public function locate(Name $name) : SourceCode
    {
        throw new SourceNotFound(\sprintf('Null locator won\'t find any source, tried to find "%s"', $name->__toString()));
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\SourceCodeLocator\\NullSourceLocator', 'Phpactor\\WorseReflection\\Core\\SourceCodeLocator\\NullSourceLocator', \false);
