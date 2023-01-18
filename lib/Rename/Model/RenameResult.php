<?php

namespace Phpactor202301\Phpactor\Rename\Model;

use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
class RenameResult
{
    public function __construct(private TextDocumentUri $oldUri, private TextDocumentUri $newUri)
    {
    }
    public function oldUri() : TextDocumentUri
    {
        return $this->oldUri;
    }
    public function newUri() : TextDocumentUri
    {
        return $this->newUri;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Rename\\Model\\RenameResult', 'Phpactor\\Rename\\Model\\RenameResult', \false);
