<?php

namespace Phpactor202301\Phpactor\Indexer\Model\Query;

use Generator;
use Phpactor202301\Phpactor\Indexer\Model\Index;
use Phpactor202301\Phpactor\Indexer\Model\IndexQuery;
use Phpactor202301\Phpactor\Indexer\Model\LocationConfidence;
use Phpactor202301\Phpactor\Indexer\Model\Record\FileRecord;
use Phpactor202301\Phpactor\Indexer\Model\Record\FunctionRecord;
use Phpactor202301\Phpactor\TextDocument\Location;
class FunctionQuery implements IndexQuery
{
    public function __construct(private Index $index)
    {
    }
    public function get(string $identifier) : ?FunctionRecord
    {
        $prototype = FunctionRecord::fromName($identifier);
        return $this->index->has($prototype) ? $this->index->get($prototype) : null;
    }
    /**
     * @return Generator<LocationConfidence>
     */
    public function referencesTo(string $identifier) : Generator
    {
        $record = $this->get($identifier);
        foreach ($record->references() as $fileReference) {
            $fileRecord = $this->index->get(FileRecord::fromPath($fileReference));
            \assert($fileRecord instanceof FileRecord);
            foreach ($fileRecord->references()->to($record) as $functionReference) {
                (yield LocationConfidence::surely(Location::fromPathAndOffset($fileRecord->filePath(), $functionReference->offset())));
            }
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\Query\\FunctionQuery', 'Phpactor\\Indexer\\Model\\Query\\FunctionQuery', \false);
