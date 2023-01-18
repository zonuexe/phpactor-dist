<?php

namespace Phpactor202301\Phpactor\Indexer\Model\Record;

interface HasFileReferences
{
    /**
     * @return $this
     */
    public function addReference(string $path);
    /**
     * @return $this
     */
    public function removeReference(string $path);
    /**
     * @return array<string>
     */
    public function references() : array;
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\Record\\HasFileReferences', 'Phpactor\\Indexer\\Model\\Record\\HasFileReferences', \false);
