<?php

namespace Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;

use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
use Phpactor202301\Phpactor\Indexer\Model\Record;
use Phpactor202301\Phpactor\Indexer\Model\Record\FunctionRecord;
class IsFunction extends Criteria
{
    public function isSatisfiedBy(Record $record) : bool
    {
        return $record instanceof FunctionRecord;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\Query\\Criteria\\IsFunction', 'Phpactor\\Indexer\\Model\\Query\\Criteria\\IsFunction', \false);
