<?php

namespace Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;

use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
use Phpactor202301\Phpactor\Indexer\Model\Record;
class TrueCriteria extends Criteria
{
    public function isSatisfiedBy(Record $record) : bool
    {
        return \true;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\Query\\Criteria\\TrueCriteria', 'Phpactor\\Indexer\\Model\\Query\\Criteria\\TrueCriteria', \false);
