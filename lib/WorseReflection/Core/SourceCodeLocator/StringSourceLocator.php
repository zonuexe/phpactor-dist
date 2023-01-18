<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator;

use Phpactor202301\Phpactor\WorseReflection\Core\Name;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode;
class StringSourceLocator implements SourceCodeLocator
{
    public function __construct(private SourceCode $source)
    {
    }
    public function locate(Name $className) : SourceCode
    {
        return $this->source;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\SourceCodeLocator\\StringSourceLocator', 'Phpactor\\WorseReflection\\Core\\SourceCodeLocator\\StringSourceLocator', \false);
