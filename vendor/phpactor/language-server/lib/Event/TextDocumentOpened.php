<?php

namespace Phpactor202301\Phpactor\LanguageServer\Event;

use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
class TextDocumentOpened
{
    /**
     * @var TextDocumentItem
     */
    private $textDocument;
    public function __construct(TextDocumentItem $textDocument)
    {
        $this->textDocument = $textDocument;
    }
    public function textDocument() : TextDocumentItem
    {
        return $this->textDocument;
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Event\\TextDocumentOpened', 'Phpactor\\LanguageServer\\Event\\TextDocumentOpened', \false);
