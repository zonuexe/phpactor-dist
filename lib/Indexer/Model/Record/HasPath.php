<?php

namespace Phpactor202301\Phpactor\Indexer\Model\Record;

interface HasPath
{
    /**
     * @return $this
     */
    public function setFilePath(string $filePath);
    public function filePath() : ?string;
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\Record\\HasPath', 'Phpactor\\Indexer\\Model\\Record\\HasPath', \false);
