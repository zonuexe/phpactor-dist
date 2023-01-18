<?php

namespace Phpactor202301\Phpactor\Indexer;

use Phpactor202301\Phpactor\Filesystem\Domain\FilePath;
use Phpactor202301\Phpactor\Filesystem\Adapter\Simple\SimpleFileListProvider;
use Phpactor202301\Phpactor\Filesystem\Adapter\Simple\SimpleFilesystem;
use Phpactor202301\Phpactor\Indexer\Adapter\Filesystem\FilesystemFileListProvider;
use Phpactor202301\Phpactor\Indexer\Adapter\Php\FileSearchIndex;
use Phpactor202301\Phpactor\Indexer\Adapter\Php\Serialized\FileRepository;
use Phpactor202301\Phpactor\Indexer\Adapter\Php\Serialized\SerializedIndex;
use Phpactor202301\Phpactor\Indexer\Adapter\Tolerant\TolerantIndexBuilder;
use Phpactor202301\Phpactor\Indexer\Adapter\Tolerant\TolerantIndexer;
use Phpactor202301\Phpactor\Indexer\Model\FileListProvider;
use Phpactor202301\Phpactor\Indexer\Model\FileListProvider\ChainFileListProvider;
use Phpactor202301\Phpactor\Indexer\Model\FileListProvider\DirtyFileListProvider;
use Phpactor202301\Phpactor\Indexer\Model\Index;
use Phpactor202301\Phpactor\Indexer\Model\IndexAccess;
use Phpactor202301\Phpactor\Indexer\Model\Index\SearchAwareIndex;
use Phpactor202301\Phpactor\Indexer\Model\RealIndexAgent;
use Phpactor202301\Phpactor\Indexer\Model\IndexBuilder;
use Phpactor202301\Phpactor\Indexer\Model\QueryClient;
use Phpactor202301\Phpactor\Indexer\Model\Indexer;
use Phpactor202301\Phpactor\Indexer\Model\RecordReferenceEnhancer;
use Phpactor202301\Phpactor\Indexer\Model\RecordReferenceEnhancer\NullRecordReferenceEnhancer;
use Phpactor202301\Phpactor\Indexer\Model\RecordSerializer;
use Phpactor202301\Phpactor\Indexer\Model\RecordSerializer\PhpSerializer;
use Phpactor202301\Phpactor\Indexer\Model\Record\ClassRecord;
use Phpactor202301\Phpactor\Indexer\Model\Record\ConstantRecord;
use Phpactor202301\Phpactor\Indexer\Model\Record\FunctionRecord;
use Phpactor202301\Phpactor\Indexer\Model\SearchClient\HydratingSearchClient;
use Phpactor202301\Phpactor\Indexer\Model\SearchIndex;
use Phpactor202301\Phpactor\Indexer\Model\SearchIndex\FilteredSearchIndex;
use Phpactor202301\Phpactor\Indexer\Model\SearchIndex\ValidatingSearchIndex;
use Phpactor202301\Phpactor\Indexer\Model\TestIndexAgent;
use Phpactor202301\Psr\Log\LoggerInterface;
use Phpactor202301\Psr\Log\NullLogger;
final class IndexAgentBuilder
{
    private RecordReferenceEnhancer $enhancer;
    /**
     * @var array<string>
     */
    private array $includePatterns = ['/**/*.php'];
    /**
     * @var array<string>
     */
    private array $stubPaths = [];
    /**
     * @var array<string>
     */
    private array $excludePatterns = [];
    /**
     * @var array<TolerantIndexer>|null
     */
    private ?array $indexers = null;
    private bool $followSymlinks = \false;
    private LoggerInterface $logger;
    private function __construct(private string $indexRoot, private string $projectRoot)
    {
        $this->enhancer = new NullRecordReferenceEnhancer();
        $this->logger = new NullLogger();
    }
    public static function create(string $indexRootPath, string $projectRoot) : self
    {
        return new self($indexRootPath, $projectRoot);
    }
    public function setLogger(LoggerInterface $logger) : self
    {
        $this->logger = $logger;
        return $this;
    }
    public function addStubPath(string $path) : self
    {
        $this->stubPaths[] = $path;
        return $this;
    }
    public function setReferenceEnhancer(RecordReferenceEnhancer $enhancer) : self
    {
        $this->enhancer = $enhancer;
        return $this;
    }
    public function buildAgent() : IndexAgent
    {
        return $this->buildTestAgent();
    }
    public function buildTestAgent() : TestIndexAgent
    {
        $index = $this->buildIndex();
        $search = $this->buildSearch($index);
        $index = new SearchAwareIndex($index, $search);
        $query = $this->buildQuery($index);
        $builder = $this->buildBuilder($index);
        $indexer = $this->buildIndexer($builder, $index);
        $search = new HydratingSearchClient($index, $search);
        return new RealIndexAgent($index, $query, $search, $indexer);
    }
    /**
     * @param array<TolerantIndexer> $indexers
     */
    public function setIndexers(array $indexers) : self
    {
        $this->indexers = $indexers;
        return $this;
    }
    /**
     * @param array<string> $excludePatterns
     */
    public function setExcludePatterns(array $excludePatterns) : self
    {
        $this->excludePatterns = $excludePatterns;
        return $this;
    }
    /**
     * @param array<string> $includePatterns
     */
    public function setIncludePatterns(array $includePatterns) : self
    {
        $this->includePatterns = $includePatterns;
        return $this;
    }
    public function setFollowSymlinks(bool $followSymlinks) : self
    {
        $this->followSymlinks = $followSymlinks;
        return $this;
    }
    /**
     * @param array<string> $stubPaths
     */
    public function setStubPaths(array $stubPaths) : self
    {
        $this->stubPaths = $stubPaths;
        return $this;
    }
    private function buildIndex() : Index
    {
        $repository = new FileRepository($this->indexRoot, $this->buildRecordSerializer(), $this->logger);
        return new SerializedIndex($repository);
    }
    private function buildQuery(Index $index) : QueryClient
    {
        return new QueryClient($index, $this->enhancer);
    }
    private function buildSearch(IndexAccess $index) : SearchIndex
    {
        $search = new FileSearchIndex($this->indexRoot . '/search');
        $search = new ValidatingSearchIndex($search, $index, $this->logger);
        $search = new FilteredSearchIndex($search, [ClassRecord::RECORD_TYPE, FunctionRecord::RECORD_TYPE, ConstantRecord::RECORD_TYPE]);
        return $search;
    }
    private function buildBuilder(Index $index) : IndexBuilder
    {
        if (null !== $this->indexers) {
            return new TolerantIndexBuilder($index, $this->indexers, $this->logger);
        }
        return TolerantIndexBuilder::create($index);
    }
    private function buildIndexer(IndexBuilder $builder, Index $index) : Indexer
    {
        return new Indexer($builder, $index, $this->buildFileListProvider(), $this->buildDirtyTracker());
    }
    private function buildFileListProvider() : FileListProvider
    {
        return new ChainFileListProvider(...$this->buildFileListProviders());
    }
    private function buildFilesystem(string $root) : SimpleFilesystem
    {
        return new SimpleFilesystem($this->indexRoot, new SimpleFileListProvider(FilePath::fromString($root), $this->followSymlinks));
    }
    private function buildRecordSerializer() : RecordSerializer
    {
        return new PhpSerializer();
    }
    /**
     * @return array<FileListProvider>
     */
    private function buildFileListProviders() : array
    {
        $providers = [new FilesystemFileListProvider($this->buildFilesystem($this->projectRoot), $this->includePatterns, $this->excludePatterns)];
        foreach ($this->stubPaths as $stubPath) {
            $providers[] = new FilesystemFileListProvider($this->buildFilesystem($stubPath));
        }
        $providers[] = $this->buildDirtyTracker();
        return $providers;
    }
    private function buildDirtyTracker() : DirtyFileListProvider
    {
        return new DirtyFileListProvider($this->indexRoot . '/dirty');
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\IndexAgentBuilder', 'Phpactor\\Indexer\\IndexAgentBuilder', \false);