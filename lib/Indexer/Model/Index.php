<?php

namespace Phpactor\Indexer\Model;

use SplFileInfo;
interface Index extends \Phpactor\Indexer\Model\IndexAccess
{
    public function lastUpdate() : int;
    public function write(\Phpactor\Indexer\Model\Record $record) : void;
    public function isFresh(SplFileInfo $fileInfo) : bool;
    public function reset() : void;
    public function exists() : bool;
    public function done() : void;
}
