<?php

namespace Phpactor\ClassFileConverter\Domain;

interface ClassToFile
{
    public function classToFileCandidates(\Phpactor\ClassFileConverter\Domain\ClassName $className) : \Phpactor\ClassFileConverter\Domain\FilePathCandidates;
}
