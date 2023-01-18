<?php

namespace Phpactor202301\Phpactor\Indexer\Model;

use Phpactor202301\Phpactor\Indexer\Model\Record\ClassRecord;
use Phpactor202301\Phpactor\Indexer\Model\Record\FunctionRecord;
interface IndexWriter
{
    public function class(ClassRecord $class) : void;
    public function timestamp() : void;
    public function function(FunctionRecord $function) : void;
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\IndexWriter', 'Phpactor\\Indexer\\Model\\IndexWriter', \false);
