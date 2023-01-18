<?php

namespace Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;

use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
use Phpactor202301\Phpactor\Indexer\Model\Record;
use Phpactor202301\Phpactor\Indexer\Model\Record\MemberRecord;
class IsMember extends Criteria
{
    public function isSatisfiedBy(Record $record) : bool
    {
        return $record instanceof MemberRecord;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\Query\\Criteria\\IsMember', 'Phpactor\\Indexer\\Model\\Query\\Criteria\\IsMember', \false);
