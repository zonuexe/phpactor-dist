<?php

namespace Phpactor202301\Phpactor\FilePathResolver\Expander\Xdg;

class XdgDataExpander extends AbstractXdgExpander
{
    public function replacementValue() : string
    {
        return $this->xdg->getHomeDataDir();
    }
}
\class_alias('Phpactor202301\\Phpactor\\FilePathResolver\\Expander\\Xdg\\XdgDataExpander', 'Phpactor\\FilePathResolver\\Expander\\Xdg\\XdgDataExpander', \false);
