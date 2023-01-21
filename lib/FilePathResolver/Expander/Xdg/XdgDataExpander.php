<?php

namespace Phpactor\FilePathResolver\Expander\Xdg;

class XdgDataExpander extends \Phpactor\FilePathResolver\Expander\Xdg\AbstractXdgExpander
{
    public function replacementValue() : string
    {
        return $this->xdg->getHomeDataDir();
    }
}
