<?php

namespace Phpactor\FilePathResolver\Expander\Xdg;

class XdgConfigExpander extends \Phpactor\FilePathResolver\Expander\Xdg\AbstractXdgExpander
{
    public function replacementValue() : string
    {
        return $this->xdg->getHomeConfigDir();
    }
}
