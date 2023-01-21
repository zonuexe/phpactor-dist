<?php

namespace Phpactor\Completion\Core;

use Generator;
use Phpactor\TextDocument\ByteOffset;
use Phpactor\TextDocument\TextDocument;
class ChainCompletor implements \Phpactor\Completion\Core\Completor
{
    /**
     * @param Completor[] $completors
     */
    public function __construct(private array $completors)
    {
    }
    public function complete(TextDocument $source, ByteOffset $offset) : Generator
    {
        $isComplete = \true;
        foreach ($this->completors as $completor) {
            $suggestions = $completor->complete($source, $offset);
            yield from $suggestions;
            $isComplete = $isComplete && $suggestions->getReturn();
        }
        return $isComplete;
    }
}
