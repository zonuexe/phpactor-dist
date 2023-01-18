<?php

namespace Phpactor202301\Phpactor\Indexer\Model;

use SplFileInfo;
interface Index extends IndexAccess
{
    public function lastUpdate() : int;
    public function write(Record $record) : void;
    public function isFresh(SplFileInfo $fileInfo) : bool;
    public function reset() : void;
    public function exists() : bool;
    public function done() : void;
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\Index', 'Phpactor\\Indexer\\Model\\Index', \false);
