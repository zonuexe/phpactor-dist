<?php

namespace Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;

use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
use Phpactor202301\Phpactor\Indexer\Model\Record;
use Phpactor202301\Phpactor\Indexer\Model\Record\ClassRecord;
class IsClass extends Criteria
{
    public function isSatisfiedBy(Record $record) : bool
    {
        return $record instanceof ClassRecord;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\Query\\Criteria\\IsClass', 'Phpactor\\Indexer\\Model\\Query\\Criteria\\IsClass', \false);
