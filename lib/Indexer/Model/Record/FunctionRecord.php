<?php

namespace Phpactor202301\Phpactor\Indexer\Model\Record;

use Phpactor202301\Phpactor\Indexer\Model\Record;
final class FunctionRecord implements HasFileReferences, HasPath, Record, HasFullyQualifiedName
{
    use FullyQualifiedReferenceTrait;
    use HasFileReferencesTrait;
    use HasPathTrait;
    public const RECORD_TYPE = 'function';
    public static function fromName(string $name) : self
    {
        return new self($name);
    }
    public function recordType() : string
    {
        return self::RECORD_TYPE;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\Record\\FunctionRecord', 'Phpactor\\Indexer\\Model\\Record\\FunctionRecord', \false);
