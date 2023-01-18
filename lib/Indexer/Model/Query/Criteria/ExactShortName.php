<?php

namespace Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;

use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
use Phpactor202301\Phpactor\Indexer\Model\Record;
use Phpactor202301\Phpactor\Indexer\Model\Record\HasShortName;
class ExactShortName extends Criteria
{
    public function __construct(private string $name)
    {
    }
    public function isSatisfiedBy(Record $record) : bool
    {
        if (!$record instanceof HasShortName) {
            return \false;
        }
        return $record->shortName() === $this->name;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\Query\\Criteria\\ExactShortName', 'Phpactor\\Indexer\\Model\\Query\\Criteria\\ExactShortName', \false);
