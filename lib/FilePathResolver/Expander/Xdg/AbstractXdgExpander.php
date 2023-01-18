<?php

namespace Phpactor202301\Phpactor\FilePathResolver\Expander\Xdg;

use Phpactor202301\Phpactor\FilePathResolver\Expander;
use Phpactor202301\XdgBaseDir\Xdg;
abstract class AbstractXdgExpander implements Expander
{
    protected Xdg $xdg;
    public function __construct(private string $name, Xdg $xdg = null)
    {
        $this->xdg = $xdg ?: new Xdg();
    }
    public function tokenName() : string
    {
        return $this->name;
    }
}
\class_alias('Phpactor202301\\Phpactor\\FilePathResolver\\Expander\\Xdg\\AbstractXdgExpander', 'Phpactor\\FilePathResolver\\Expander\\Xdg\\AbstractXdgExpander', \false);
