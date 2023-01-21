<?php

namespace Phpactor\ClassFileConverter\Domain;

interface FileToClass
{
    public function fileToClassCandidates(\Phpactor\ClassFileConverter\Domain\FilePath $filePath) : \Phpactor\ClassFileConverter\Domain\ClassNameCandidates;
}
