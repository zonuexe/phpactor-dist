<?php

namespace Phpactor202301\Phpactor\ReferenceFinder\Search;

use Generator;
use Phpactor202301\Phpactor\ReferenceFinder\NameSearcher;
class NullNameSearcher implements NameSearcher
{
    public function search(string $search, ?string $type = null) : Generator
    {
        yield from [];
    }
}
\class_alias('Phpactor202301\\Phpactor\\ReferenceFinder\\Search\\NullNameSearcher', 'Phpactor\\ReferenceFinder\\Search\\NullNameSearcher', \false);
