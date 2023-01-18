<?php

namespace Phpactor202301\Phpactor\Extension\CompletionExtra\Application;

use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\Completion\Core\TypedCompletorRegistry;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
class Complete
{
    public function __construct(private TypedCompletorRegistry $registry)
    {
    }
    public function complete(string $source, int $offset, string $type = 'php') : array
    {
        $completor = $this->registry->completorForType($type);
        $suggestions = $completor->complete(TextDocumentBuilder::create($source)->language($type)->build(), ByteOffset::fromInt($offset));
        $suggestions = \iterator_to_array($suggestions);
        $suggestions = \array_map(function (Suggestion $suggestion) {
            return $suggestion->toArray();
        }, $suggestions);
        return [
            'suggestions' => $suggestions,
            // deprecated
            'issues' => [],
        ];
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\CompletionExtra\\Application\\Complete', 'Phpactor\\Extension\\CompletionExtra\\Application\\Complete', \false);
