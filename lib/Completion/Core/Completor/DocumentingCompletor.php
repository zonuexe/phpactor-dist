<?php

namespace Phpactor202301\Phpactor\Completion\Core\Completor;

use Generator;
use Phpactor202301\Phpactor\Completion\Core\Completor;
use Phpactor202301\Phpactor\Completion\Core\SuggestionDocumentor;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
class DocumentingCompletor implements Completor
{
    public function __construct(private Completor $innerCompletor, private SuggestionDocumentor $documentor)
    {
    }
    public function complete(TextDocument $source, ByteOffset $byteOffset) : Generator
    {
        $suggestions = $this->innerCompletor->complete($source, $byteOffset);
        foreach ($suggestions as $suggestion) {
            if (\false === $suggestion->hasDocumentation()) {
                $suggestion = $suggestion->withDocumentation($this->documentor->document($suggestion));
            }
            (yield $suggestion);
        }
        return $suggestions->getReturn();
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Core\\Completor\\DocumentingCompletor', 'Phpactor\\Completion\\Core\\Completor\\DocumentingCompletor', \false);
