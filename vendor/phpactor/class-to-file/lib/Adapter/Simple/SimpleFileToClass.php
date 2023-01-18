<?php

namespace Phpactor202301\Phpactor\ClassFileConverter\Adapter\Simple;

use Phpactor202301\Phpactor\ClassFileConverter\Domain\FileToClass;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\ClassNameCandidates;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\FilePath;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\ClassName;
class SimpleFileToClass implements FileToClass
{
    /**
     * @var ClassScanner
     */
    private $classScanner;
    public function __construct()
    {
        $this->classScanner = new ClassScanner();
    }
    public function fileToClassCandidates(FilePath $filePath) : ClassNameCandidates
    {
        $classNames = [];
        $className = $this->classScanner->getClassNameFromFile($filePath->__toString());
        if ($className) {
            $classNames[] = ClassName::fromString($className);
        }
        return ClassNameCandidates::fromClassNames($classNames);
    }
}
\class_alias('Phpactor202301\\Phpactor\\ClassFileConverter\\Adapter\\Simple\\SimpleFileToClass', 'Phpactor\\ClassFileConverter\\Adapter\\Simple\\SimpleFileToClass', \false);
