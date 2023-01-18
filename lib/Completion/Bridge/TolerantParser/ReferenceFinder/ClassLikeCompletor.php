<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\ReferenceFinder;

use Generator;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\ClassBaseClause;
use Phpactor202301\Microsoft\PhpParser\Node\ClassInterfaceClause;
use Phpactor202301\Microsoft\PhpParser\Node\InterfaceBaseClause;
use Phpactor202301\Microsoft\PhpParser\Node\TraitUseClause;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\CompletionContext;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantCompletor;
use Phpactor202301\Phpactor\Completion\Core\DocumentPrioritizer\DocumentPrioritizer;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\ReferenceFinder\NameSearcher;
use Phpactor202301\Phpactor\ReferenceFinder\NameSearcherType;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
class ClassLikeCompletor implements TolerantCompletor
{
    public function __construct(private NameSearcher $nameSearcher, private DocumentPrioritizer $prioritizer)
    {
    }
    public function complete(Node $node, TextDocument $source, ByteOffset $offset) : Generator
    {
        if (!CompletionContext::classLike($node)) {
            return \true;
        }
        $search = $node->getText();
        $type = $this->resolveType($node);
        foreach ($this->nameSearcher->search($search, $type) as $result) {
            if (!$result->type()->isClass()) {
                continue;
            }
            (yield Suggestion::createWithOptions($result->name()->head(), ['type' => Suggestion::TYPE_CLASS, 'priority' => $this->prioritizer->priority($result->uri(), $source->uri()), 'short_description' => \sprintf('%s %s', $type ?: '', $result->name()->__toString()), 'class_import' => $result->name()->__toString(), 'name_import' => $result->name()->__toString()]));
        }
        return \true;
    }
    /**
     * @return NameSearcherType::INTERFACE|NameSearcherType::CLASS_|NameSearcherType::TRAIT
     */
    private function resolveType(Node $node) : ?string
    {
        if (CompletionContext::nodeOrParentIs($node->parent, InterfaceBaseClause::class)) {
            return NameSearcherType::INTERFACE;
        }
        if (CompletionContext::nodeOrParentIs($node->parent, ClassInterfaceClause::class)) {
            return NameSearcherType::INTERFACE;
        }
        if (CompletionContext::nodeOrParentIs($node->parent, ClassBaseClause::class)) {
            return NameSearcherType::CLASS_;
        }
        if (CompletionContext::nodeOrParentIs($node->parent, TraitUseClause::class)) {
            return NameSearcherType::TRAIT;
        }
        return null;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\TolerantParser\\ReferenceFinder\\ClassLikeCompletor', 'Phpactor\\Completion\\Bridge\\TolerantParser\\ReferenceFinder\\ClassLikeCompletor', \false);
