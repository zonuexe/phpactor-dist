<?php

namespace Phpactor\ClassFileConverter\Domain;

use PhpactorDist\Symfony\Component\Filesystem\Path;
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
    public static function fromString($path) : \Phpactor\ClassFileConverter\Domain\FilePath
    {
        return new self($path);
    }
    public static function fromParts(array $parts) : \Phpactor\ClassFileConverter\Domain\FilePath
    {
        $path = \implode('/', $parts);
        return new self($path);
    }
}
