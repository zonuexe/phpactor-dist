<?php

namespace Phpactor202301\Phpactor\Indexer\Model\Record;

use Phpactor202301\Phpactor\Indexer\Model\Name\FullyQualifiedName;
interface HasFullyQualifiedName extends HasShortName
{
    public function fqn() : FullyQualifiedName;
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\Record\\HasFullyQualifiedName', 'Phpactor\\Indexer\\Model\\Record\\HasFullyQualifiedName', \false);
