<?php

namespace Phpactor202301\Phpactor\Completion\Core\DocumentPrioritizer;

use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
interface DocumentPrioritizer
{
    public function priority(?TextDocumentUri $one, ?TextDocumentUri $two) : int;
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Core\\DocumentPrioritizer\\DocumentPrioritizer', 'Phpactor\\Completion\\Core\\DocumentPrioritizer\\DocumentPrioritizer', \false);
