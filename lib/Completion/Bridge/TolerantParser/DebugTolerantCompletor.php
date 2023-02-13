<?php

namespace Phpactor\Completion\Bridge\TolerantParser;

use Generator;
use PhpactorDist\Microsoft\PhpParser\Node;
use Phpactor\Completion\Bridge\TolerantParser\Qualifier\AlwaysQualfifier;
use Phpactor\TextDocument\ByteOffset;
use Phpactor\TextDocument\TextDocument;
use Phpactor\WorseReflection\Core\ClassName;
class DebugTolerantCompletor implements \Phpactor\Completion\Bridge\TolerantParser\TolerantCompletor, \Phpactor\Completion\Bridge\TolerantParser\TolerantQualifiable
{
    public function __construct(private \Phpactor\Completion\Bridge\TolerantParser\TolerantCompletor $innerCompletor)
    {
    }
    public function complete(Node $node, TextDocument $source, ByteOffset $offset) : Generator
    {
        $generator = $this->innerCompletor->complete($node, $source, $offset);
        foreach ($generator as $result) {
            (yield $result->withShortDescription(\sprintf('[c: %s,n:%s<%s<%s] %s', ClassName::fromString(\get_class($this->innerCompletor))->short(), ClassName::fromString(\get_class($node))->short(), $node->parent ? ClassName::fromString(\get_class($node->parent))->short() : '-', $node->parent->parent ? ClassName::fromString(\get_class($node->parent->parent))->short() : '-', $result->shortDescription())));
        }
        return $generator->getReturn();
    }
    public function qualifier() : \Phpactor\Completion\Bridge\TolerantParser\TolerantQualifier
    {
        if ($this->innerCompletor instanceof \Phpactor\Completion\Bridge\TolerantParser\TolerantQualifiable) {
            return $this->innerCompletor->qualifier();
        }
        return new AlwaysQualfifier();
    }
}
