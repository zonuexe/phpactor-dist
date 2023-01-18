<?php

namespace Phpactor202301\Phpactor\ClassFileConverter\Domain;

class ChainClassToFile implements ClassToFile
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
    public function classToFileCandidates(ClassName $className) : FilePathCandidates
    {
        $paths = [];
        foreach ($this->converters as $converter) {
            foreach ($converter->classToFileCandidates($className) as $candidate) {
                $paths[] = $candidate;
            }
        }
        return FilePathCandidates::fromFilePaths($paths);
    }
    private function add(ClassToFile $classToFile) : void
    {
        $this->converters[] = $classToFile;
    }
}
\class_alias('Phpactor202301\\Phpactor\\ClassFileConverter\\Domain\\ChainClassToFile', 'Phpactor\\ClassFileConverter\\Domain\\ChainClassToFile', \false);
