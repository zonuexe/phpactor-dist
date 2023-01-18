<?php

namespace Phpactor202301\Phpactor\Indexer\Model\Record;

use Phpactor202301\Phpactor\Indexer\Model\Record;
final class ConstantRecord implements HasPath, Record, HasFullyQualifiedName
{
    use FullyQualifiedReferenceTrait;
    use HasPathTrait;
    public const RECORD_TYPE = 'constant';
    public static function fromName(string $name) : self
    {
        return new self($name);
    }
    public function recordType() : string
    {
        return self::RECORD_TYPE;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\Record\\ConstantRecord', 'Phpactor\\Indexer\\Model\\Record\\ConstantRecord', \false);
