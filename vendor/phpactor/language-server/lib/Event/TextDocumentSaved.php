<?php

namespace Phpactor202301\Phpactor\LanguageServer\Event;

use Phpactor202301\Phpactor\LanguageServerProtocol\VersionedTextDocumentIdentifier;
class TextDocumentSaved
{
    /**
     * @var VersionedTextDocumentIdentifier
     */
    private $identifier;
    /**
     * @var string|null
     */
    private $text;
    public function __construct(VersionedTextDocumentIdentifier $identifier, ?string $text = null)
    {
        $this->identifier = $identifier;
        $this->text = $text;
    }
    public function identifier() : VersionedTextDocumentIdentifier
    {
        return $this->identifier;
    }
    public function text() : ?string
    {
        return $this->text;
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Event\\TextDocumentSaved', 'Phpactor\\LanguageServer\\Event\\TextDocumentSaved', \false);
