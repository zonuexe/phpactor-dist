<?php

namespace Phpactor\Indexer\Model\Record;

use Phpactor\Indexer\Model\Name\FullyQualifiedName;
interface HasFullyQualifiedName extends \Phpactor\Indexer\Model\Record\HasShortName
{
    public function fqn() : FullyQualifiedName;
}
