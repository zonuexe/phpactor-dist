<?php

namespace Phpactor202301\Phpactor\Indexer\Adapter\Worse;

use Phpactor202301\Phpactor\Indexer\Model\IndexAccess;
use Phpactor202301\Phpactor\Indexer\Model\Record\ConstantRecord;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\SourceNotFound;
use Phpactor202301\Phpactor\WorseReflection\Core\Name;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator;
class IndexerConstantSourceLocator implements SourceCodeLocator
{
    public function __construct(private IndexAccess $index)
    {
    }
    public function locate(Name $name) : SourceCode
    {
        if (empty($name->__toString())) {
            throw new SourceNotFound('Name is empty');
        }
        $record = $this->index->get(ConstantRecord::fromName($name->__toString()));
        $filePath = $record->filePath();
        if (null === $filePath) {
            throw new SourceNotFound('constant not indexed');
        }
        if (!\file_exists($filePath)) {
            throw new SourceNotFound(\sprintf('Constant "%s" is indexed, but it does not exist at path "%s"!', $name->full(), $filePath));
        }
        return SourceCode::fromPath($filePath);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Adapter\\Worse\\IndexerConstantSourceLocator', 'Phpactor\\Indexer\\Adapter\\Worse\\IndexerConstantSourceLocator', \false);
