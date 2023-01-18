<?php

namespace Phpactor202301\Phpactor\ReferenceFinder\Search;

use Phpactor202301\Phpactor\Name\FullyQualifiedName;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
final class NameSearchResult
{
    private function __construct(private NameSearchResultType $type, private FullyQualifiedName $name, private ?TextDocumentUri $uri = null)
    {
    }
    /**
     * @param string|FullyQualifiedName $name
     * @param string|NameSearchResultType $type
     * @param string|TextDocumentUri $uri
     */
    public static function create($type, $name, $uri = null) : self
    {
        return new self(\is_string($type) ? new NameSearchResultType($type) : $type, \is_string($name) ? FullyQualifiedName::fromString($name) : $name, $uri ? \is_string($uri) ? TextDocumentUri::fromString($uri) : $uri : null);
    }
    public function name() : FullyQualifiedName
    {
        return $this->name;
    }
    public function type() : NameSearchResultType
    {
        return $this->type;
    }
    public function uri() : ?TextDocumentUri
    {
        return $this->uri;
    }
}
\class_alias('Phpactor202301\\Phpactor\\ReferenceFinder\\Search\\NameSearchResult', 'Phpactor\\ReferenceFinder\\Search\\NameSearchResult', \false);
