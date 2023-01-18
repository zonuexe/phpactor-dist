<?php

namespace Phpactor202301\Phpactor\Indexer\Model;

interface Matcher
{
    public function match(string $subject, string $query) : bool;
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\Matcher', 'Phpactor\\Indexer\\Model\\Matcher', \false);
