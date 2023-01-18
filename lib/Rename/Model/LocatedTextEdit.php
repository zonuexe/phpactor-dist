<?php

namespace Phpactor202301\Phpactor\Rename\Model;

use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use Phpactor202301\Phpactor\TextDocument\TextEdit;
final class LocatedTextEdit
{
    public function __construct(private TextDocumentUri $documentUri, private TextEdit $textEdit)
    {
    }
    public function textEdit() : TextEdit
    {
        return $this->textEdit;
    }
    public function documentUri() : TextDocumentUri
    {
        return $this->documentUri;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Rename\\Model\\LocatedTextEdit', 'Phpactor\\Rename\\Model\\LocatedTextEdit', \false);
