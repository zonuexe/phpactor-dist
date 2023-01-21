<?php

namespace Phpactor\ClassFileConverter\Domain;

class ChainClassToFile implements \Phpactor\ClassFileConverter\Domain\ClassToFile
{
    /**
     * @var array
     */
    private $converters = [];
    public function __construct(array $converters)
    {
        foreach ($converters as $converter) {
            $this->add($converter);
        }
    }
    public function classToFileCandidates(\Phpactor\ClassFileConverter\Domain\ClassName $className) : \Phpactor\ClassFileConverter\Domain\FilePathCandidates
    {
        $paths = [];
        foreach ($this->converters as $converter) {
            foreach ($converter->classToFileCandidates($className) as $candidate) {
                $paths[] = $candidate;
            }
        }
        return \Phpactor\ClassFileConverter\Domain\FilePathCandidates::fromFilePaths($paths);
    }
    private function add(\Phpactor\ClassFileConverter\Domain\ClassToFile $classToFile) : void
    {
        $this->converters[] = $classToFile;
    }
}
