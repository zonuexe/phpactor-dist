<?php

namespace Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;

use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
use Phpactor202301\Phpactor\Indexer\Model\Record;
class OrCriteria extends Criteria
{
    /**
     * @var array<Criteria>
     */
    private array $criterias;
    public function __construct(Criteria ...$criterias)
    {
        $this->criterias = $criterias;
    }
    public function isSatisfiedBy(Record $record) : bool
    {
        foreach ($this->criterias as $criteria) {
            if (\true === $criteria->isSatisfiedBy($record)) {
                return \true;
            }
        }
        return \false;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\Query\\Criteria\\OrCriteria', 'Phpactor\\Indexer\\Model\\Query\\Criteria\\OrCriteria', \false);
