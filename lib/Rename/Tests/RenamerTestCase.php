<?php

namespace Phpactor202301\Phpactor\Rename\Tests;

use Closure;
use Generator;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Indexer\Adapter\Worse\WorseRecordReferenceEnhancer;
use Phpactor202301\Phpactor\Indexer\IndexAgent;
use Phpactor202301\Phpactor\Indexer\IndexAgentBuilder;
use Phpactor202301\Phpactor\Rename\Model\LocatedTextEdit;
use Phpactor202301\Phpactor\Rename\Model\LocatedTextEdits;
use Phpactor202301\Phpactor\Rename\Model\Renamer;
use Phpactor202301\Phpactor\TestUtils\Workspace;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator\BruteForceSourceLocator;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
use Phpactor202301\Psr\Log\NullLogger;
use Phpactor202301\Symfony\Component\Process\Process;
abstract class RenamerTestCase extends TestCase
{
    protected IndexAgent $indexAgent;
    protected Reflector $reflector;
    protected function setUp() : void
    {
        $this->workspace()->reset();
        $this->reflector = ReflectorBuilder::create()->addLocator(new BruteForceSourceLocator(ReflectorBuilder::create()->build(), $this->workspace()->path('project')))->build();
        $this->indexAgent = IndexAgentBuilder::create($this->workspace()->path('index'), $this->workspace()->path('project'))->setReferenceEnhancer(new WorseRecordReferenceEnhancer($this->reflector, new NullLogger()))->buildAgent();
    }
    /**
     * @dataProvider provideRename
     * @param Closure(Reflector,Renamer):Generator<LocatedTextEdit> $operation
     */
    public function testRename(string $path, Closure $operation, Closure $assertion) : void
    {
        $basePath = __DIR__ . '/Cases/' . $path;
        foreach ((array) \glob($basePath . '/**.ph') as $path) {
            $this->workspace()->put('project/' . (string) \substr((string) $path, \strlen($basePath)) . 'p', (string) \file_get_contents((string) $path));
        }
        $this->indexAgent->indexer()->getJob()->run();
        $generator = $operation($this->reflector, $this->createRenamer());
        $edits = LocatedTextEdits::fromLocatedEditsToCollection(\iterator_to_array($generator, \false));
        foreach ($edits as $documentEdits) {
            \file_put_contents($documentEdits->documentUri()->path(), $documentEdits->textEdits()->apply((string) \file_get_contents($documentEdits->documentUri()->path())));
        }
        $process = Process::fromShellCommandline('php ' . $this->workspace()->path('project/test.php'));
        $process->mustRun();
        $assertion($this->reflector);
    }
    protected function workspace() : Workspace
    {
        return new Workspace(__DIR__ . '/Workspace');
    }
    protected abstract function createRenamer() : Renamer;
}
\class_alias('Phpactor202301\\Phpactor\\Rename\\Tests\\RenamerTestCase', 'Phpactor\\Rename\\Tests\\RenamerTestCase', \false);
