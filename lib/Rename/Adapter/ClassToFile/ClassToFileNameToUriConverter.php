<?php

namespace Phpactor202301\Phpactor\Rename\Adapter\ClassToFile;

use Phpactor202301\Phpactor\ClassFileConverter\Domain\ClassName;
use Phpactor202301\Phpactor\ClassFileConverter\Domain\ClassToFile;
use Phpactor202301\Phpactor\Rename\Model\Exception\CouldNotConvertClassToUri;
use Phpactor202301\Phpactor\Rename\Model\NameToUriConverter;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use RuntimeException;
class ClassToFileNameToUriConverter implements NameToUriConverter
{
    public function __construct(private ClassToFile $classToFile)
    {
    }
    public function convert(string $className) : TextDocumentUri
    {
        try {
            return TextDocumentUri::fromString($this->classToFile->classToFileCandidates(ClassName::fromString($className))->best());
        } catch (RuntimeException $error) {
            throw new CouldNotConvertClassToUri($error->getMessage(), 0, $error);
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\Rename\\Adapter\\ClassToFile\\ClassToFileNameToUriConverter', 'Phpactor\\Rename\\Adapter\\ClassToFile\\ClassToFileNameToUriConverter', \false);
