<?php

namespace Phpactor202301\Phpactor\Indexer\Adapter\Php\Serialized;

use Phpactor202301\Phpactor\Indexer\Model\Index;
use Phpactor202301\Phpactor\Indexer\Model\Record;
use RuntimeException;
use SplFileInfo;
class SerializedIndex implements Index
{
    public function __construct(private FileRepository $repository)
    {
    }
    public function lastUpdate() : int
    {
        return $this->repository->lastUpdate();
    }
    public function get(Record $record) : Record
    {
        return $this->repository->get($record) ?? $record;
    }
    public function write(Record $record) : void
    {
        $this->repository->put($record);
    }
    public function isFresh(SplFileInfo $fileInfo) : bool
    {
        try {
            $mtime = $fileInfo->getCTime();
        } catch (RuntimeException) {
            // file likely doesn't exist
            return \false;
        }
        return $mtime < $this->lastUpdate();
    }
    public function reset() : void
    {
        $this->repository->reset();
    }
    public function exists() : bool
    {
        return $this->repository->lastUpdate() > 0;
    }
    public function done() : void
    {
        $this->repository->flush();
        $this->repository->putTimestamp();
    }
    public function has(Record $record) : bool
    {
        return $this->repository->get($record) ? \true : \false;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Adapter\\Php\\Serialized\\SerializedIndex', 'Phpactor\\Indexer\\Adapter\\Php\\Serialized\\SerializedIndex', \false);
