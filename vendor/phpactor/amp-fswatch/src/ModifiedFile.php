<?php

namespace Phpactor202301\Phpactor\AmpFsWatch;

use Phpactor202301\Webmozart\PathUtil\Path;
class ModifiedFile
{
    const TYPE_FILE = 'file';
    const TYPE_FOLDER = 'folder';
    /**
     * @var string
     */
    private $path;
    /**
     * @var string
     */
    private $type;
    public function __construct(string $path, string $type)
    {
        $this->path = Path::canonicalize($path);
        $this->type = $type;
    }
    public function path() : string
    {
        return $this->path;
    }
    public function type() : string
    {
        return $this->type;
    }
}
\class_alias('Phpactor202301\\Phpactor\\AmpFsWatch\\ModifiedFile', 'Phpactor\\AmpFsWatch\\ModifiedFile', \false);
