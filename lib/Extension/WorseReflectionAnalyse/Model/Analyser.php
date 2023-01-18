<?php

namespace Phpactor202301\Phpactor\Extension\WorseReflectionAnalyse\Model;

use Generator;
use Phpactor202301\Phpactor\Filesystem\Domain\FileList;
use Phpactor202301\Phpactor\Filesystem\Domain\FilePath;
use Phpactor202301\Phpactor\Filesystem\Domain\FilesystemRegistry;
use Phpactor202301\Phpactor\WorseReflection\Core\Diagnostic;
use Phpactor202301\Phpactor\WorseReflection\Core\Diagnostics;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflector\SourceCodeReflector;
use RuntimeException;
use Phpactor202301\Symfony\Component\Filesystem\Path;
use Throwable;
class Analyser
{
    public function __construct(private FilesystemRegistry $filesystem, private SourceCodeReflector $reflector)
    {
    }
    /**
     * @return Generator<string,Diagnostics<Diagnostic>>
     */
    public function analyse(string $path) : Generator
    {
        $cwd = (string) \getcwd();
        $absPath = Path::makeAbsolute($path, $cwd);
        if (\file_exists($absPath) && \is_file($absPath)) {
            (yield $path => $this->reflector->diagnostics((string) \file_get_contents($absPath)));
            return;
        }
        foreach ($this->fileList($absPath) as $file) {
            try {
                (yield Path::makeRelative($file->path(), $cwd) => $this->reflector->diagnostics((string) \file_get_contents($file->path())));
            } catch (Throwable $error) {
                throw new RuntimeException(\sprintf('Error while analysing file "%s": %s', $file, $error->getMessage()), 0, $error);
            }
        }
    }
    public function fileList(string $path) : FileList
    {
        $cwd = (string) \getcwd();
        $absPath = Path::makeAbsolute($path, $cwd);
        $filesystem = $this->filesystem->get('git');
        return $filesystem->fileList()->phpFiles()->within(FilePath::fromString($absPath));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\WorseReflectionAnalyse\\Model\\Analyser', 'Phpactor\\Extension\\WorseReflectionAnalyse\\Model\\Analyser', \false);
