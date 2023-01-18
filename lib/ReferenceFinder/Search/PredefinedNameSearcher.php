<?php

namespace Phpactor202301\Phpactor\ReferenceFinder\Search;

use Generator;
use Phpactor202301\Phpactor\ReferenceFinder\NameSearcher;
class PredefinedNameSearcher implements NameSearcher
{
    /**
     * @param NameSearchResult[] $results
     */
    public function __construct(private array $results)
    {
    }
    /**
     * @return Generator<NameSearchResult>
     */
    public function search(string $search, ?string $type = null) : Generator
    {
        foreach ($this->results as $result) {
            if (!\str_starts_with($result->name()->head()->__toString(), $search)) {
                continue;
            }
            (yield $result);
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\ReferenceFinder\\Search\\PredefinedNameSearcher', 'Phpactor\\ReferenceFinder\\Search\\PredefinedNameSearcher', \false);
