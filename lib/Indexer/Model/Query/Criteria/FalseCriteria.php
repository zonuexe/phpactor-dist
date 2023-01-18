<?php

namespace Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;

use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
use Phpactor202301\Phpactor\Indexer\Model\Record;
class FalseCriteria extends Criteria
{
    public function isSatisfiedBy(Record $record) : bool
    {
        return \false;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\Query\\Criteria\\FalseCriteria', 'Phpactor\\Indexer\\Model\\Query\\Criteria\\FalseCriteria', \false);
