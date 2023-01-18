<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\Composer;

use Phpactor202301\Phpactor\WorseReflection\Core\Name;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator;
use Phpactor202301\Composer\Autoload\ClassLoader;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\SourceNotFound;
class ComposerSourceLocator implements SourceCodeLocator
{
    public function __construct(private ClassLoader $classLoader)
    {
    }
    public function locate(Name $className) : SourceCode
    {
        $path = $this->classLoader->findFile((string) $className);
        if (\false === $path) {
            throw new SourceNotFound(\sprintf('Composer could not locate file for class "%s"', $className->full()));
        }
        return SourceCode::fromPath($path);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\Composer\\ComposerSourceLocator', 'Phpactor\\WorseReflection\\Bridge\\Composer\\ComposerSourceLocator', \false);
