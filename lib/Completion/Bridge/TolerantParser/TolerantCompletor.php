<?php

namespace Phpactor\Completion\Bridge\TolerantParser;

use Generator;
use PhpactorDist\Microsoft\PhpParser\Node;
use Phpactor\Completion\Core\Suggestion;
use Phpactor\TextDocument\ByteOffset;
use Phpactor\TextDocument\TextDocument;
interface TolerantCompletor
{
    /**
     * @return Generator<Suggestion>
     */
    public function complete(Node $node, TextDocument $source, ByteOffset $offset) : Generator;
}
