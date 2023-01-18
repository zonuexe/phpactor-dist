<?php

namespace Phpactor202301\Phpactor\Rename\Model;

use Phpactor202301\Phpactor\Rename\Model\Exception\CouldNotConvertUriToClass;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
interface UriToNameConverter
{
    /**
     * @throws CouldNotConvertUriToClass
     */
    public function convert(TextDocumentUri $uri) : string;
}
\class_alias('Phpactor202301\\Phpactor\\Rename\\Model\\UriToNameConverter', 'Phpactor\\Rename\\Model\\UriToNameConverter', \false);
