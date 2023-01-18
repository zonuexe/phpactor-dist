<?php

namespace Phpactor202301\Phpactor\Completion\Core\Completor;

use Generator;
use Phpactor202301\Phpactor\Completion\Core\Completor;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
class ArrayCompletor implements Completor
{
    /**
     * @param Suggestion[] $suggestions
     */
    public function __construct(private array $suggestions)
    {
    }
    public function complete(TextDocument $source, ByteOffset $byteOffset) : Generator
    {
        yield from $this->suggestions;
        return \true;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Core\\Completor\\ArrayCompletor', 'Phpactor\\Completion\\Core\\Completor\\ArrayCompletor', \false);
