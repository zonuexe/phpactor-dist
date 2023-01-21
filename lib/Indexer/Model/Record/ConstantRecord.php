<?php

namespace Phpactor\Indexer\Model\Record;

use Phpactor\Indexer\Model\Record;
final class ConstantRecord implements \Phpactor\Indexer\Model\Record\HasPath, Record, \Phpactor\Indexer\Model\Record\HasFullyQualifiedName
{
    use \Phpactor\Indexer\Model\Record\FullyQualifiedReferenceTrait;
    use \Phpactor\Indexer\Model\Record\HasPathTrait;
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
