<?php

namespace Phpactor202301\Phpactor\WorseReferenceFinder\Tests;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\TestUtils\Workspace;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator\StubSourceLocator;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
abstract class IntegrationTestCase extends TestCase
{
    protected Workspace $workspace;
    public function setUp() : void
    {
        $this->workspace = Workspace::create(__DIR__ . '/Workspace');
        $this->workspace->reset();
    }
    protected function reflector() : Reflector
    {
        return ReflectorBuilder::create()->enableContextualSourceLocation()->addLocator(new StubSourceLocator(ReflectorBuilder::create()->build(), $this->workspace->path(''), $this->workspace->path('cache')))->build();
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReferenceFinder\\Tests\\IntegrationTestCase', 'Phpactor\\WorseReferenceFinder\\Tests\\IntegrationTestCase', \false);
