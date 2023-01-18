<?php

namespace Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;

use Phpactor202301\Phpactor\Indexer\Model\Query\Criteria;
use Phpactor202301\Phpactor\Indexer\Model\Record;
class AndCriteria extends Criteria
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
            if (\false === $criteria->isSatisfiedBy($record)) {
                return \false;
            }
        }
        return \true;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\Query\\Criteria\\AndCriteria', 'Phpactor\\Indexer\\Model\\Query\\Criteria\\AndCriteria', \false);
