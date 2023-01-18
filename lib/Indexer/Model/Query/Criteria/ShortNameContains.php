<?php

namespace Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;

use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
use Phpactor202301\Phpactor\Indexer\Model\Record;
use Phpactor202301\Phpactor\Indexer\Model\Record\HasShortName;
class ShortNameContains extends Criteria
{
    public function __construct(private string $substr)
    {
    }
    public function isSatisfiedBy(Record $record) : bool
    {
        if (!$record instanceof HasShortName) {
            return \false;
        }
        return \false !== \stripos($record->shortName(), $this->substr);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\Query\\Criteria\\ShortNameContains', 'Phpactor\\Indexer\\Model\\Query\\Criteria\\ShortNameContains', \false);
