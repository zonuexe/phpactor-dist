<?php

namespace Phpactor202301\Phpactor\LanguageServer\Event;

use Phpactor202301\Phpactor\LanguageServerProtocol\VersionedTextDocumentIdentifier;
class TextDocumentUpdated
{
    /**
     * @var VersionedTextDocumentIdentifier
     */
    private $identifier;
    /**
     * @var string
     */
    private $updatedText;
    public function __construct(VersionedTextDocumentIdentifier $identifier, string $updatedText)
    {
        $this->identifier = $identifier;
        $this->updatedText = $updatedText;
    }
    public function identifier() : VersionedTextDocumentIdentifier
    {
        return $this->identifier;
    }
    public function updatedText() : string
    {
        return $this->updatedText;
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Event\\TextDocumentUpdated', 'Phpactor\\LanguageServer\\Event\\TextDocumentUpdated', \false);
