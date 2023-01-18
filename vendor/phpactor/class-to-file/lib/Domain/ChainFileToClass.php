<?php

namespace Phpactor202301\Phpactor\ClassFileConverter\Domain;

class ChainFileToClass implements FileToClass
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
    public function fileToClassCandidates(FilePath $filePath) : ClassNameCandidates
    {
        $classNames = [];
        foreach ($this->converters as $converter) {
            foreach ($converter->fileToClassCandidates($filePath) as $candidate) {
                $classNames[] = $candidate;
            }
        }
        return ClassNameCandidates::fromClassNames($classNames);
    }
    private function add(FileToClass $fileToClass) : void
    {
        $this->converters[] = $fileToClass;
    }
}
\class_alias('Phpactor202301\\Phpactor\\ClassFileConverter\\Domain\\ChainFileToClass', 'Phpactor\\ClassFileConverter\\Domain\\ChainFileToClass', \false);
