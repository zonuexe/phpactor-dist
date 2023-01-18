<?php

namespace Phpactor202301\Phpactor\Extension\Core\Application;

use Phpactor202301\Symfony\Component\Filesystem\Filesystem;
use Phpactor202301\Symfony\Component\Filesystem\Path;
class CacheClear
{
    private string $cachePath;
    private Filesystem $filesystem;
    public function __construct(string $cachePath)
    {
        $this->cachePath = Path::canonicalize($cachePath);
        $this->filesystem = new Filesystem();
    }
    public function clearCache() : void
    {
        $this->filesystem->remove($this->cachePath);
    }
    public function cachePath()
    {
        return $this->cachePath;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Core\\Application\\CacheClear', 'Phpactor\\Extension\\Core\\Application\\CacheClear', \false);
