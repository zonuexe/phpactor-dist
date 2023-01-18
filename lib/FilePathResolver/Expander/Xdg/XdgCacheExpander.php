<?php

namespace Phpactor202301\Phpactor\FilePathResolver\Expander\Xdg;

class XdgCacheExpander extends AbstractXdgExpander
{
    public function replacementValue() : string
    {
        return $this->xdg->getHomeCacheDir();
    }
}
\class_alias('Phpactor202301\\Phpactor\\FilePathResolver\\Expander\\Xdg\\XdgCacheExpander', 'Phpactor\\FilePathResolver\\Expander\\Xdg\\XdgCacheExpander', \false);
