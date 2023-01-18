<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Domain\TemplatePathResolver;

use Iterator;
use FilterIterator;
use RuntimeException;
use SplFileInfo;
class FilterPhpVersionDirectoryIterator extends FilterIterator
{
    /**
     * @param string $phpVersion
     *      String the form of "major.minor.release[extra]"
     *      @see https://www.php.net/manual/en/reserved.constants.php#reserved.constants.core
     */
    public function __construct(Iterator $iterator, private string $phpVersion)
    {
        parent::__construct($iterator);
    }
    public function accept() : bool
    {
        $file = $this->current();
        if (!$file instanceof SplFileInfo) {
            throw new RuntimeException(\sprintf('Expected instance of "\\SplFileInfo", got "%s".', \is_object($file) ? \get_class($file) : \gettype($file)));
        }
        $filename = $file->getFilename();
        if (!$file->isDir() || !\preg_match('/^\\d+\\.\\d+/', $filename) || !\version_compare($filename, $this->phpVersion, '<=')) {
            return \false;
        }
        return \true;
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Domain\\TemplatePathResolver\\FilterPhpVersionDirectoryIterator', 'Phpactor\\CodeBuilder\\Domain\\TemplatePathResolver\\FilterPhpVersionDirectoryIterator', \false);
