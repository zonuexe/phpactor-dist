<?php

declare (strict_types=1);
namespace Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\WorseReflection;

use Generator;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\CompletionContext;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantCompletor;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
class KeywordCompletor implements TolerantCompletor
{
    public function complete(Node $node, TextDocument $source, ByteOffset $offset) : Generator
    {
        if (CompletionContext::classClause($node, $offset)) {
            yield from $this->keywords(['implements ', 'extends ']);
            return \true;
        }
        if (CompletionContext::declaration($node, $offset)) {
            yield from $this->keywords(['class ', 'trait ', 'function ', 'interface ']);
            return \true;
        }
        if (CompletionContext::methodName($node)) {
            yield from $this->keywords(['__construct(']);
            return \true;
        }
        if (CompletionContext::classMembersBody($node->parent)) {
            yield from $this->keywords(['function ', 'const ']);
            return \true;
        }
        if (CompletionContext::classMembersBody($node)) {
            yield from $this->keywords(['private ', 'protected ', 'public ']);
            return \true;
        }
        return \true;
    }
    /**
     * @return Generator<Suggestion>
     * @param string[] $keywords
     */
    private function keywords(array $keywords) : Generator
    {
        foreach ($keywords as $keyword) {
            (yield Suggestion::createWithOptions($keyword, ['type' => Suggestion::TYPE_KEYWORD, 'priority' => 1]));
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\TolerantParser\\WorseReflection\\KeywordCompletor', 'Phpactor\\Completion\\Bridge\\TolerantParser\\WorseReflection\\KeywordCompletor', \false);