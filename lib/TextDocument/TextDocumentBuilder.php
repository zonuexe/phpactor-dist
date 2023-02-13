<?php

namespace Phpactor\TextDocument;

use Phpactor\TextDocument\Exception\TextDocumentNotFound;
use RuntimeException;
use PhpactorDist\Symfony\Component\Filesystem\Path;
final class TextDocumentBuilder
{
    private ?\Phpactor\TextDocument\TextDocumentUri $uri = null;
    private ?\Phpactor\TextDocument\TextDocumentLanguage $language = null;
    private function __construct(private string $text)
    {
    }
    public static function create(string $text) : self
    {
        return new self($text);
    }
    public static function fromUri(string $uri, ?string $language = null) : self
    {
        $uri = \Phpactor\TextDocument\TextDocumentUri::fromString($uri);
        if (!\file_exists($uri)) {
            throw new TextDocumentNotFound(\sprintf('Text Document not found at URI "%s"', $uri));
        }
        if (!\is_readable($uri)) {
            throw new RuntimeException(\sprintf('Could not read file at URI "%s"', $uri));
        }
        if (null === $language) {
            $language = Path::getExtension((string) $uri);
        }
        $contents = \file_get_contents($uri);
        if (\false === $contents) {
            throw new RuntimeException(\sprintf('Could not read file at URI "%s"', $uri));
        }
        $new = new self($contents);
        $new->uri = $uri;
        $new->language = \Phpactor\TextDocument\TextDocumentLanguage::fromString($language);
        return $new;
    }
    public static function fromTextDocument(\Phpactor\TextDocument\TextDocument $document) : self
    {
        $new = new self($document->__toString());
        $new->uri = $document->uri();
        $new->language = $document->language();
        return $new;
    }
    public function uri(string $uri) : self
    {
        $this->uri = \Phpactor\TextDocument\TextDocumentUri::fromString($uri);
        return $this;
    }
    public function language(string $language) : self
    {
        $this->language = \Phpactor\TextDocument\TextDocumentLanguage::fromString($language);
        return $this;
    }
    public function text(string $text) : self
    {
        $this->text = $text;
        return $this;
    }
    public function build() : \Phpactor\TextDocument\TextDocument
    {
        return new \Phpactor\TextDocument\StandardTextDocument($this->language ?? \Phpactor\TextDocument\TextDocumentLanguage::undefined(), $this->text, $this->uri);
    }
}
