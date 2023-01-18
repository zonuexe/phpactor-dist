<?php

namespace Phpactor202301\Phpactor\ClassFileConverter\Domain;

interface ClassToFile
{
    public function classToFileCandidates(ClassName $className) : FilePathCandidates;
}
\class_alias('Phpactor202301\\Phpactor\\ClassFileConverter\\Domain\\ClassToFile', 'Phpactor\\ClassFileConverter\\Domain\\ClassToFile', \false);
