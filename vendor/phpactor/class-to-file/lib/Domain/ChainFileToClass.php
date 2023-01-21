<?php

namespace Phpactor\ClassFileConverter\Domain;

class ChainFileToClass implements \Phpactor\ClassFileConverter\Domain\FileToClass
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
    public function fileToClassCandidates(\Phpactor\ClassFileConverter\Domain\FilePath $filePath) : \Phpactor\ClassFileConverter\Domain\ClassNameCandidates
    {
        $classNames = [];
        foreach ($this->converters as $converter) {
            foreach ($converter->fileToClassCandidates($filePath) as $candidate) {
                $classNames[] = $candidate;
            }
        }
        return \Phpactor\ClassFileConverter\Domain\ClassNameCandidates::fromClassNames($classNames);
    }
    private function add(\Phpactor\ClassFileConverter\Domain\FileToClass $fileToClass) : void
    {
        $this->converters[] = $fileToClass;
    }
}
