<?php

namespace Phpactor\Rename\Model;

use Phpactor\Rename\Model\Exception\CouldNotConvertUriToClass;
use Phpactor\TextDocument\TextDocumentUri;
interface UriToNameConverter
{
    /**
     * @throws CouldNotConvertUriToClass
     */
    public function convert(TextDocumentUri $uri) : string;
}
