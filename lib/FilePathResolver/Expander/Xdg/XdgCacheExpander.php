<?php

namespace Phpactor\FilePathResolver\Expander\Xdg;

class XdgCacheExpander extends \Phpactor\FilePathResolver\Expander\Xdg\AbstractXdgExpander
{
    public function replacementValue() : string
    {
        return $this->xdg->getHomeCacheDir();
    }
}
