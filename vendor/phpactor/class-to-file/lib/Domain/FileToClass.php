<?php

namespace Phpactor202301\Phpactor\ClassFileConverter\Domain;

interface FileToClass
{
    public function fileToClassCandidates(FilePath $filePath) : ClassNameCandidates;
}
\class_alias('Phpactor202301\\Phpactor\\ClassFileConverter\\Domain\\FileToClass', 'Phpactor\\ClassFileConverter\\Domain\\FileToClass', \false);
