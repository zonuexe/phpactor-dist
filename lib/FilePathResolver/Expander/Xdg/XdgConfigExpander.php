<?php

namespace Phpactor202301\Phpactor\FilePathResolver\Expander\Xdg;

class XdgConfigExpander extends AbstractXdgExpander
{
    public function replacementValue() : string
    {
        return $this->xdg->getHomeConfigDir();
    }
}
\class_alias('Phpactor202301\\Phpactor\\FilePathResolver\\Expander\\Xdg\\XdgConfigExpander', 'Phpactor\\FilePathResolver\\Expander\\Xdg\\XdgConfigExpander', \false);
