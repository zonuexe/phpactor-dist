<?php

namespace Phpactor202301\Phpactor\Rename\Adapter\ClassToFile;

use Phpactor202301\Phpactor\ClassFileConverter\Domain\FilePath;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\FileToClass;
use Phpactor202301\Phpactor\Rename\Model\Exception\CouldNotConvertUriToClass;
use Phpactor202301\Phpactor\Rename\Model\UriToNameConverter;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use RuntimeException;
class ClassToFileUriToNameConverter implements UriToNameConverter
{
    public function __construct(private FileToClass $fileToClass)
    {
    }
    public function convert(TextDocumentUri $uri) : string
    {
        try {
            return $this->fileToClass->fileToClassCandidates(FilePath::fromString($uri->path()))->best()->__toString();
        } catch (RuntimeException $error) {
            throw new CouldNotConvertUriToClass($error->getMessage(), 0, $error);
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\Rename\\Adapter\\ClassToFile\\ClassToFileUriToNameConverter', 'Phpactor\\Rename\\Adapter\\ClassToFile\\ClassToFileUriToNameConverter', \false);
