<?php

namespace Phpactor202301\Phpactor\ClassFileConverter;

use Phpactor202301\Phpactor\ClassFileConverter\Adapter\Composer\ComposerFileToClass;
use Phpactor202301\Phpactor\ClassFileConverter\Adapter\Composer\ComposerClassToFile;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\ClassToFileFileToClass;
use Phpactor202301\Composer\Autoload\ClassLoader;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\ChainClassToFile;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\ChainFileToClass;
/**
 * Facade for the library.
 */
final class ClassToFileConverter
{
    private $converter;
    private function __construct(ClassToFileFileToClass $converter)
    {
        $this->converter = $converter;
    }
    public static function fromComposerAutoloader(ClassLoader $classLoader) : ClassToFileFileToClass
    {
        return new ClassToFileFileToClass(new ComposerClassToFile($classLoader), new ComposerFileToClass($classLoader));
    }
    public static function fromComposerAutoloaders(array $classLoaders) : ClassToFileFileToClass
    {
        $classToFiles = $fileToClasses = [];
        foreach ($classLoaders as $classLoader) {
            $classToFiles[] = new ComposerClassToFile($classLoader);
        }
        foreach ($classLoaders as $classLoader) {
            $fileToClasses[] = new ComposerFileToClass($classLoader);
        }
        return new ClassToFileFileToClass(new ChainClassToFile($classToFiles), new ChainFileToClass($fileToClasses));
    }
}
/**
 * Facade for the library.
 */
\class_alias('Phpactor202301\\Phpactor\\ClassFileConverter\\ClassToFileConverter', 'Phpactor\\ClassFileConverter\\ClassToFileConverter', \false);
