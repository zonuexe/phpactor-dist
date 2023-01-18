<?php

namespace Phpactor202301\Phpactor\TextDocument\TextDocumentLocator;

use Phpactor202301\Phpactor\TextDocument\Exception\TextDocumentNotFound;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use Phpactor202301\Phpactor\TextDocument\TextDocumentLocator;
final class InMemoryDocumentLocator implements TextDocumentLocator
{
    /**
     * @param array<string, TextDocument> $documents
     */
    private function __construct(private array $documents)
    {
    }
    public function get(TextDocumentUri $uri) : TextDocument
    {
        if (isset($this->documents[$uri->__toString()])) {
            return $this->documents[$uri->__toString()];
        }
        throw TextDocumentNotFound::fromUri($uri);
    }
    /**
     * @param TextDocument[] $textDocuments
     */
    public static function fromTextDocuments(array $textDocuments) : self
    {
        /** @phpstan-ignore-next-line */
        return new self((array) \array_combine(\array_map(function (TextDocument $document) : string {
            return $document->uri()->__toString();
        }, $textDocuments), \array_values($textDocuments)));
    }
    public static function new() : self
    {
        return new self([]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\TextDocument\\TextDocumentLocator\\InMemoryDocumentLocator', 'Phpactor\\TextDocument\\TextDocumentLocator\\InMemoryDocumentLocator', \false);
