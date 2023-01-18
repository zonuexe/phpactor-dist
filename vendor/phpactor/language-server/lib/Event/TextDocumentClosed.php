<?php

namespace Phpactor202301\Phpactor\LanguageServer\Event;

use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentIdentifier;
class TextDocumentClosed
{
    /**
     * @var TextDocumentIdentifier
     */
    private $identifier;
    public function __construct(TextDocumentIdentifier $identifier)
    {
        $this->identifier = $identifier;
    }
    public function identifier() : TextDocumentIdentifier
    {
        return $this->identifier;
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Event\\TextDocumentClosed', 'Phpactor\\LanguageServer\\Event\\TextDocumentClosed', \false);
