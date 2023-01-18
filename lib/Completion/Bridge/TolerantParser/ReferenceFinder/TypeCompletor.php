<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\ReferenceFinder;

use Generator;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\CompletionContext;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantCompletor;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TypeSuggestionProvider;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
class TypeCompletor implements TolerantCompletor
{
    public function __construct(private TypeSuggestionProvider $provider)
    {
    }
    public function complete(Node $node, TextDocument $source, ByteOffset $offset) : Generator
    {
        if (!CompletionContext::type($node)) {
            return \true;
        }
        yield from $this->provider->provide($node, $node->getText());
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\TolerantParser\\ReferenceFinder\\TypeCompletor', 'Phpactor\\Completion\\Bridge\\TolerantParser\\ReferenceFinder\\TypeCompletor', \false);
