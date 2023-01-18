<?php

namespace Phpactor202301\Phpactor\Indexer\Model\Record;

use Phpactor202301\Phpactor\Indexer\Model\Exception\CorruptedRecord;
use Phpactor202301\Phpactor\Indexer\Model\Record;
use Phpactor202301\Phpactor\Indexer\Model\RecordReference;
use Phpactor202301\Phpactor\Indexer\Model\RecordReferences;
use SplFileInfo;
class FileRecord implements HasPath, Record
{
    use HasPathTrait;
    public const RECORD_TYPE = 'file';
    /**
     * @var array<array{string,string,int}>
     */
    private $references = [];
    public function __construct(string $filePath)
    {
        $this->setFilePath($filePath);
    }
    public function __wakeup() : void
    {
        if (null === $this->filePath) {
            throw new CorruptedRecord(\sprintf('Record was corrupted'));
        }
    }
    public function recordType() : string
    {
        return self::RECORD_TYPE;
    }
    public static function fromFileInfo(SplFileInfo $info) : self
    {
        return new self($info->getPathname());
    }
    public static function fromPath(string $path) : self
    {
        return new self($path);
    }
    public function identifier() : string
    {
        return $this->filePath();
    }
    public function addReference(RecordReference $reference) : self
    {
        $this->references[] = [$reference->type(), $reference->identifier(), $reference->offset(), $reference->contaninerType()];
        return $this;
    }
    public function references() : RecordReferences
    {
        return new RecordReferences($this, \array_map(function (array $reference) {
            return new RecordReference(...$reference);
        }, $this->references));
    }
    public function removeReferencesToRecordType(string $type) : self
    {
        $this->references = \array_filter($this->references, function (array $reference) use($type) {
            return $reference[0] !== $type;
        });
        return $this;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\Record\\FileRecord', 'Phpactor\\Indexer\\Model\\Record\\FileRecord', \false);
