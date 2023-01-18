<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\TolerantParser;

use Generator;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\Qualifier\AlwaysQualfifier;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
class LimitingCompletor implements TolerantCompletor, TolerantQualifiable
{
    public function __construct(private TolerantCompletor $completor, private int $limit = 50)
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
    public function qualifier() : TolerantQualifier
    {
        if (!$this->completor instanceof TolerantQualifiable) {
            return new AlwaysQualfifier();
        }
        return $this->completor->qualifier();
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\TolerantParser\\LimitingCompletor', 'Phpactor\\Completion\\Bridge\\TolerantParser\\LimitingCompletor', \false);
