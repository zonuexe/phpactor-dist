<?php

namespace Phpactor202301\Phpactor\ReferenceFinder;

use Generator;
use Phpactor202301\Phpactor\ReferenceFinder\Search\NameSearchResult;
interface NameSearcher
{
    /**
     * @return Generator<NameSearchResult>
     * @param NameSearcherType::* $type
     */
    public function search(string $search, ?string $type = null) : Generator;
}
\class_alias('Phpactor202301\\Phpactor\\ReferenceFinder\\NameSearcher', 'Phpactor\\ReferenceFinder\\NameSearcher', \false);
