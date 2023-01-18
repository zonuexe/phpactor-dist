<?php

namespace Phpactor202301\Phpactor\ConfigLoader\Adapter\PathCandidate;

use Phpactor202301\Phpactor\ConfigLoader\Core\PathCandidate;
use Phpactor202301\Symfony\Component\Filesystem\Path;
use Phpactor202301\XdgBaseDir\Xdg;
class XdgPathCandidate implements PathCandidate
{
    public function __construct(private string $appName, private string $filename, private string $loader, private Xdg $xdg)
    {
    }
    public function path() : string
    {
        return Path::join($this->xdg->getHomeConfigDir(), $this->appName, $this->filename);
    }
    public function loader() : string
    {
        return $this->loader;
    }
}
\class_alias('Phpactor202301\\Phpactor\\ConfigLoader\\Adapter\\PathCandidate\\XdgPathCandidate', 'Phpactor\\ConfigLoader\\Adapter\\PathCandidate\\XdgPathCandidate', \false);
