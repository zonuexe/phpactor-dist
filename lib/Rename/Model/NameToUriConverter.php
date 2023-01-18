<?php

namespace Phpactor202301\Phpactor\Rename\Model;

use Phpactor202301\Phpactor\Rename\Model\Exception\CouldNotConvertUriToClass;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
interface NameToUriConverter
{
    /**
     * @throws CouldNotConvertUriToClass
     */
    public function convert(string $uri) : TextDocumentUri;
}
\class_alias('Phpactor202301\\Phpactor\\Rename\\Model\\NameToUriConverter', 'Phpactor\\Rename\\Model\\NameToUriConverter', \false);
