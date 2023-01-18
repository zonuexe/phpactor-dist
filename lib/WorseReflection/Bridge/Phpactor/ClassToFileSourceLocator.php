<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\Phpactor;

use Phpactor202301\Phpactor\ClassFileConverter\Domain\ClassToFile;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\SourceNotFound;
use Phpactor202301\Phpactor\WorseReflection\Core\Name;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\ClassName;
class ClassToFileSourceLocator implements SourceCodeLocator
{
    public function __construct(private ClassToFile $converter)
    {
    }
    public function locate(Name $name) : SourceCode
    {
        $candidates = $this->converter->classToFileCandidates(ClassName::fromString((string) $name));
        if ($candidates->noneFound()) {
            throw new SourceNotFound(\sprintf('Could not locate a candidate for "%s"', (string) $name));
        }
        foreach ($candidates as $candidate) {
            if (\file_exists((string) $candidate)) {
                return SourceCode::fromPath((string) $candidate);
            }
        }
        throw new SourceNotFound($name);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\Phpactor\\ClassToFileSourceLocator', 'Phpactor\\WorseReflection\\Bridge\\Phpactor\\ClassToFileSourceLocator', \false);
