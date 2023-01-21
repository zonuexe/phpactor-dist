<?php

namespace Phpactor\Completion\Bridge\TolerantParser;

use Generator;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor\Completion\Bridge\TolerantParser\Qualifier\AlwaysQualfifier;
use Phpactor\TextDocument\ByteOffset;
use Phpactor\TextDocument\TextDocument;
class LimitingCompletor implements \Phpactor\Completion\Bridge\TolerantParser\TolerantCompletor, \Phpactor\Completion\Bridge\TolerantParser\TolerantQualifiable
{
    public function __construct(private \Phpactor\Completion\Bridge\TolerantParser\TolerantCompletor $completor, private int $limit = 50)
    {
    }
    public function complete(Node $node, TextDocument $source, ByteOffset $offset) : Generator
    {
        /** @var TolerantCompletor $completor */
        $completor = $this->completor;
        $count = 0;
        $suggestions = $completor->complete($node, $source, $offset);
        foreach ($suggestions as $suggestion) {
            (yield $suggestion);
            if (++$count === $this->limit) {
                return \false;
            }
        }
        return $suggestions->getReturn();
    }
    public function qualifier() : \Phpactor\Completion\Bridge\TolerantParser\TolerantQualifier
    {
        if (!$this->completor instanceof \Phpactor\Completion\Bridge\TolerantParser\TolerantQualifiable) {
            return new AlwaysQualfifier();
        }
        return $this->completor->qualifier();
    }
}
