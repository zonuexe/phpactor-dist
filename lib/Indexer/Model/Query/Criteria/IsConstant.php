<?php

namespace Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;

use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
use Phpactor202301\Phpactor\Indexer\Model\Record;
use Phpactor202301\Phpactor\Indexer\Model\Record\ConstantRecord;
class IsConstant extends Criteria
{
    public function isSatisfiedBy(Record $record) : bool
    {
        return $record instanceof ConstantRecord;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\Query\\Criteria\\IsConstant', 'Phpactor\\Indexer\\Model\\Query\\Criteria\\IsConstant', \false);
