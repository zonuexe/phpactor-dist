<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\ReferenceFinder;

use Generator;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\CompletionContext;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantCompletor;
use Phpactor202301\Phpactor\Completion\Core\DocumentPrioritizer\DocumentPrioritizer;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\ReferenceFinder\NameSearcher;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
class UseNameCompletor implements TolerantCompletor
{
    public function __construct(private NameSearcher $nameSearcher, private DocumentPrioritizer $prioritizer)
    {
    }
    public function complete(Node $node, TextDocument $source, ByteOffset $offset) : Generator
    {
        $parent = $node->parent;
        if (!CompletionContext::useImport($node)) {
            return \true;
        }
        $search = $node->getText();
        foreach ($this->nameSearcher->search($search) as $result) {
            if (!$result->type()->isClass()) {
                continue;
            }
            (yield Suggestion::createWithOptions($result->name()->__toString(), ['type' => Suggestion::TYPE_CLASS, 'priority' => $this->prioritizer->priority($result->uri(), $source->uri())]));
        }
        return \true;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\TolerantParser\\ReferenceFinder\\UseNameCompletor', 'Phpactor\\Completion\\Bridge\\TolerantParser\\ReferenceFinder\\UseNameCompletor', \false);
