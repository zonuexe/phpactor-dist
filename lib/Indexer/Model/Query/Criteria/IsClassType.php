<?php

namespace Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;

use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
use Phpactor202301\Phpactor\Indexer\Model\Record;
use Phpactor202301\Phpactor\Indexer\Model\Record\ClassRecord;
class IsClassType extends Criteria
{
    public function __construct(private ?string $type)
    {
    }
    public function isSatisfiedBy(Record $record) : bool
    {
        if (!$record instanceof ClassRecord) {
            return \false;
        }
        return $record->type() === $this->type;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\Query\\Criteria\\IsClassType', 'Phpactor\\Indexer\\Model\\Query\\Criteria\\IsClassType', \false);
