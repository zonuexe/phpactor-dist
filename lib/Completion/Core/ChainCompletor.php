<?php

namespace Phpactor202301\Phpactor\Completion\Core;

use Generator;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
class ChainCompletor implements Completor
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
\class_alias('Phpactor202301\\Phpactor\\Completion\\Core\\ChainCompletor', 'Phpactor\\Completion\\Core\\ChainCompletor', \false);
