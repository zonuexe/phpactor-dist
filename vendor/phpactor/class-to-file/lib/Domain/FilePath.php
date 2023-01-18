<?php

namespace Phpactor202301\Phpactor\ClassFileConverter\Domain;

use Phpactor202301\Symfony\Component\Filesystem\Path;
final class FilePath
{
    private $path;
    private function __construct(string $path)
    {
        $path = Path::canonicalize($path);
        $this->path = $path;
    }
    public function __toString()
    {
        return $this->path;
    }
    public function isAbsolute() : bool
    {
        return Path::isAbsolute($this->path);
    }
    public static function fromString($path) : FilePath
    {
        return new self($path);
    }
    public static function fromParts(array $parts) : FilePath
    {
        $path = \implode('/', $parts);
        return new self($path);
    }
}
\class_alias('Phpactor202301\\Phpactor\\ClassFileConverter\\Domain\\FilePath', 'Phpactor\\ClassFileConverter\\Domain\\FilePath', \false);
