<?php

namespace Phpactor202301\Phpactor\Completion\Core;

use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
interface SignatureHelper
{
    public function signatureHelp(TextDocument $textDocument, ByteOffset $offset) : SignatureHelp;
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Core\\SignatureHelper', 'Phpactor\\Completion\\Core\\SignatureHelper', \false);
