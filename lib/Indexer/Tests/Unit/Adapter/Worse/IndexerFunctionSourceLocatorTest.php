<?php

namespace Phpactor202301\Phpactor\Indexer\Tests\Unit\Adapter\Worse;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Indexer\Model\Name\FullyQualifiedName;
use Phpactor202301\Phpactor\Indexer\Adapter\Php\InMemory\InMemoryIndex;
use Phpactor202301\Phpactor\Indexer\Adapter\Worse\IndexerFunctionSourceLocator;
use Phpactor202301\Phpactor\Indexer\Model\Record\FunctionRecord;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\SourceNotFound;
use Phpactor202301\Phpactor\WorseReflection\Core\Name;
class IndexerFunctionSourceLocatorTest extends TestCase
{
    public function testThrowsExceptionIfFunctionNotInIndex() : void
    {
        $this->expectException(SourceNotFound::class);
        $index = new InMemoryIndex();
        $locator = $this->createLocator($index);
        $locator->locate(Name::fromString('Foobar'));
    }
    public function testThrowsExceptionIfFileDoesNotExist() : void
    {
        $this->expectException(SourceNotFound::class);
        $this->expectExceptionMessage('does not exist');
        $record = new FunctionRecord(FullyQualifiedName::fromString('Foobar'));
        $record->setFilePath('nope.php');
        $index = new InMemoryIndex();
        $index->write($record);
        $locator = $this->createLocator($index);
        $locator->locate(Name::fromString('Foobar'));
    }
    public function testReturnsSourceCode() : void
    {
        $record = new FunctionRecord(FullyQualifiedName::fromString('Foobar'));
        $record->setFilePath(__FILE__);
        $index = new InMemoryIndex();
        $index->write($record);
        $locator = $this->createLocator($index);
        $sourceCode = $locator->locate(Name::fromString('Foobar'));
        $this->assertEquals(__FILE__, $sourceCode->path());
    }
    private function createLocator(InMemoryIndex $index) : IndexerFunctionSourceLocator
    {
        return new IndexerFunctionSourceLocator($index);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Tests\\Unit\\Adapter\\Worse\\IndexerFunctionSourceLocatorTest', 'Phpactor\\Indexer\\Tests\\Unit\\Adapter\\Worse\\IndexerFunctionSourceLocatorTest', \false);
