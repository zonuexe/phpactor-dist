<?php

namespace Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;

use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
use Phpactor202301\Phpactor\Indexer\Model\Record;
use Phpactor202301\Phpactor\Indexer\Model\Record\HasFullyQualifiedName;
class FqnBeginsWith extends Criteria
{
    public function __construct(private string $name)
    {
    }
    public function isSatisfiedBy(Record $record) : bool
    {
        if (!$this->name) {
            return \false;
        }
        if (!$record instanceof HasFullyQualifiedName) {
            return \false;
        }
        return \str_starts_with($record->fqn()->__toString(), $this->name);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\Query\\Criteria\\FqnBeginsWith', 'Phpactor\\Indexer\\Model\\Query\\Criteria\\FqnBeginsWith', \false);
