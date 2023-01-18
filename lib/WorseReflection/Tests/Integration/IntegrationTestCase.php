<?php

namespace Phpactor202301\Phpactor\WorseReflection\Tests\Integration;

use Phpactor202301\Phpactor\TestUtils\Workspace;
use Phpactor202301\Phpactor\WorseReflection\Bridge\Phpactor\MemberProvider\DocblockMemberProvider;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Walker\TestAssertWalker;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator\StubSourceLocator;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\Microsoft\PhpParser\Node\SourceFileNode;
use Phpactor202301\Phpactor\WorseReflection\Bridge\PsrLog\ArrayLogger;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
class IntegrationTestCase extends TestCase
{
    private ArrayLogger $logger;
    public function setUp() : void
    {
        $this->logger = new ArrayLogger();
    }
    public function createBuilder(string $source) : ReflectorBuilder
    {
        return ReflectorBuilder::create()->addSource($source)->addMemberProvider(new DocblockMemberProvider())->addFrameWalker(new TestAssertWalker($this))->withLogger($this->logger());
    }
    public function createReflector(string $source) : Reflector
    {
        return $this->createBuilder($source)->build();
    }
    public function createWorkspaceReflector(string $source) : Reflector
    {
        return ReflectorBuilder::create()->addLocator(new StubSourceLocator(ReflectorBuilder::create()->build(), $this->workspace()->path('/'), $this->workspace()->path('/')))->addMemberProvider(new DocblockMemberProvider())->withLogger($this->logger())->build();
    }
    protected function logger() : ArrayLogger
    {
        return $this->logger;
    }
    protected function workspace() : Workspace
    {
        return new Workspace(__DIR__ . '/../Workspace');
    }
    protected function parseSource(string $source, string $uri = null) : SourceFileNode
    {
        $parser = new Parser();
        return $parser->parseSourceFile($source, $uri);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Tests\\Integration\\IntegrationTestCase', 'Phpactor\\WorseReflection\\Tests\\Integration\\IntegrationTestCase', \false);
