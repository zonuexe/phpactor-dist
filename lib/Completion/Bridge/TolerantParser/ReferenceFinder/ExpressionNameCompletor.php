<?php

namespace Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\ReferenceFinder;

use Generator;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\ObjectCreationExpression;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\CompletionContext;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TolerantCompletor;
use Phpactor202301\Phpactor\Completion\Core\Completor\NameSearcherCompletor as CoreNameSearcherCompletor;
use Phpactor202301\Phpactor\Completion\Core\DocumentPrioritizer\DocumentPrioritizer;
use Phpactor202301\Phpactor\Completion\Core\Formatter\ObjectFormatter;
use Phpactor202301\Phpactor\ReferenceFinder\NameSearcher;
use Phpactor202301\Phpactor\ReferenceFinder\Search\NameSearchResult;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocument;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
class ExpressionNameCompletor extends CoreNameSearcherCompletor implements TolerantCompletor
{
    public function __construct(NameSearcher $nameSearcher, private ObjectFormatter $snippetFormatter, DocumentPrioritizer $prioritizer = null)
    {
        parent::__construct($nameSearcher, $prioritizer);
    }
    public function complete(Node $node, TextDocument $source, ByteOffset $offset) : Generator
    {
        $parent = $node->parent;
        if (!CompletionContext::expression($node)) {
            return \true;
        }
        $suggestions = $this->completeName($node, $source->uri(), $node);
        yield from $suggestions;
        return $suggestions->getReturn();
    }
    protected function createSuggestionOptions(NameSearchResult $result, ?TextDocumentUri $sourceUri = null, ?Node $node = null, bool $wasAbsolute = \false) : array
    {
        $suggestionOptions = parent::createSuggestionOptions($result, $sourceUri, $node, $wasAbsolute);
        if ($this->isNonObjectCreationClassResult($result, $node) || !$this->snippetFormatter->canFormat($result)) {
            return $suggestionOptions;
        }
        return \array_merge($suggestionOptions, ['snippet' => $this->snippetFormatter->format($result)]);
    }
    private function isNonObjectCreationClassResult(NameSearchResult $result, ?Node $node) : bool
    {
        if (!$result->type()->isClass()) {
            return \false;
        }
        if ($node === null) {
            return \true;
        }
        $parent = $node->getParent();
        if ($parent === null) {
            return \true;
        }
        return !$parent instanceof ObjectCreationExpression;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Bridge\\TolerantParser\\ReferenceFinder\\ExpressionNameCompletor', 'Phpactor\\Completion\\Bridge\\TolerantParser\\ReferenceFinder\\ExpressionNameCompletor', \false);
