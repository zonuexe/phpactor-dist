<?php

namespace Phpactor\AmpFsWatch;

class ModifiedFileBuilder
{
    /**
     * @var string
     */
    private $path;
    /**
     * @var string
     */
    private $type = \Phpactor\AmpFsWatch\ModifiedFile::TYPE_FILE;
    public function __construct(string $path)
    {
        $this->path = $path;
    }
    public static function fromPathSegments(string ...$segments) : self
    {
        return new self(\implode('/', $segments));
    }
    public static function fromPath(string $path) : self
    {
        return new self($path);
    }
    public function asFile() : self
    {
        $this->type = \Phpactor\AmpFsWatch\ModifiedFile::TYPE_FILE;
        return $this;
    }
    public function asFolder() : self
    {
        $this->type = \Phpactor\AmpFsWatch\ModifiedFile::TYPE_FOLDER;
        return $this;
    }
    public function build() : \Phpactor\AmpFsWatch\ModifiedFile
    {
        return new \Phpactor\AmpFsWatch\ModifiedFile($this->path, $this->type);
    }
}
