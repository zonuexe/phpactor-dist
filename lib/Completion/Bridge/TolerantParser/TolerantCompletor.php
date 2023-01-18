<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\TolerantParser;

use Generator;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
interface TolerantCompletor
{
    /**
     * @return Generator<Suggestion>
     */
    public function complete(Node $node, TextDocument $source, ByteOffset $offset) : Generator;
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\TolerantParser\\TolerantCompletor', 'Phpactor\\Completion\\Bridge\\TolerantParser\\TolerantCompletor', \false);
