<?php

namespace Phpactor202301\Phpactor\TextDocument\Exception;

use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use RuntimeException;
final class TextDocumentNotFound extends RuntimeException
{
    public static function fromUri(TextDocumentUri $uri) : self
    {
        return new self(\sprintf('Text document "%s" not found', $uri));
    }
}
\class_alias('Phpactor202301\\Phpactor\\TextDocument\\Exception\\TextDocumentNotFound', 'Phpactor\\TextDocument\\Exception\\TextDocumentNotFound', \false);
