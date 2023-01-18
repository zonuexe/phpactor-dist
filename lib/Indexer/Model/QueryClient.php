<?php

namespace Phpactor202301\Phpactor\Indexer\Model;

use Phpactor202301\Phpactor\Indexer\Model\Query\ClassQuery;
use Phpactor202301\Phpactor\Indexer\Model\Query\ConstantQuery;
use Phpactor202301\Phpactor\Indexer\Model\Query\FileQuery;
use Phpactor202301\Phpactor\Indexer\Model\Query\FunctionQuery;
use Phpactor202301\Phpactor\Indexer\Model\Query\MemberQuery;
use Phpactor202301\Phpactor\Indexer\Model\RecordReferenceEnhancer\NullRecordReferenceEnhancer;
class QueryClient
{
    private ClassQuery $classQuery;
    private FunctionQuery $functionQuery;
    private FileQuery $fileQuery;
    private MemberQuery $memberQuery;
    private Index $index;
    private ?RecordReferenceEnhancer $enhancer;
    private ConstantQuery $constantQuery;
    public function __construct(Index $index, ?RecordReferenceEnhancer $enhancer = null)
    {
        $enhancer = $enhancer ?: new NullRecordReferenceEnhancer();
        $this->classQuery = new ClassQuery($index);
        $this->functionQuery = new FunctionQuery($index);
        $this->constantQuery = new ConstantQuery($index);
        $this->fileQuery = new FileQuery($index);
        $this->memberQuery = new MemberQuery($index, $enhancer);
        $this->index = $index;
        $this->enhancer = $enhancer;
    }
    public function class() : ClassQuery
    {
        return $this->classQuery;
    }
    public function function() : FunctionQuery
    {
        return $this->functionQuery;
    }
    public function file() : FileQuery
    {
        return $this->fileQuery;
    }
    public function member() : MemberQuery
    {
        return $this->memberQuery;
    }
    public function constant() : ConstantQuery
    {
        return $this->constantQuery;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Model\\QueryClient', 'Phpactor\\Indexer\\Model\\QueryClient', \false);
