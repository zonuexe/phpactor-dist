<?php

namespace Phpactor\ClassFileConverter\Domain;

final class ClassToFileFileToClass implements \Phpactor\ClassFileConverter\Domain\ClassToFile, \Phpactor\ClassFileConverter\Domain\FileToClass
{
    private $classToFile;
    private $fileToClass;
    public function __construct(\Phpactor\ClassFileConverter\Domain\ClassToFile $classToFile, \Phpactor\ClassFileConverter\Domain\FileToClass $fileToClass)
    {
        $this->classToFile = $classToFile;
        $this->fileToClass = $fileToClass;
    }
    public function fileToClassCandidates(\Phpactor\ClassFileConverter\Domain\FilePath $filePath) : \Phpactor\ClassFileConverter\Domain\ClassNameCandidates
    {
        return $this->fileToClass->fileToClassCandidates($filePath);
    }
    public function classToFileCandidates(\Phpactor\ClassFileConverter\Domain\ClassName $className) : \Phpactor\ClassFileConverter\Domain\FilePathCandidates
    {
        return $this->classToFile->classToFileCandidates($className);
    }
}
