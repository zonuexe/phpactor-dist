<?php

namespace Phpactor202301\Phpactor\CodeTransform\Tests\Adapter;

use Phpactor202301\Phpactor\CodeBuilder\Adapter\Twig\TwigRenderer;
use Phpactor202301\Phpactor\CodeBuilder\Adapter\TolerantParser\TolerantUpdater;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\TestUtils\Workspace;
use Phpactor202301\Phpactor\TestUtils\ExtractOffset;
class AdapterTestCase extends TestCase
{
    protected function renderer()
    {
        return new TwigRenderer();
    }
    protected function updater()
    {
        return new TolerantUpdater($this->renderer());
    }
    protected function workspace() : Workspace
    {
        return Workspace::create(__DIR__ . '/../Workspace');
    }
    protected function sourceExpected($manifestPath)
    {
        $workspace = $this->workspace();
        $workspace->reset();
        if (!\file_exists($manifestPath)) {
            \touch($manifestPath);
        }
        $workspace->loadManifest(\file_get_contents($manifestPath));
        $source = $workspace->getContents('source');
        $expected = $workspace->getContents('expected');
        return [$source, $expected];
    }
    protected function sourceExpectedAndOffset($manifestPath)
    {
        [$source, $expected] = $this->sourceExpected($manifestPath);
        [$source, $offsetStart, $offsetEnd] = ExtractOffset::fromSource($source);
        return [$source, $expected, $offsetStart, $offsetEnd];
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Tests\\Adapter\\AdapterTestCase', 'Phpactor\\CodeTransform\\Tests\\Adapter\\AdapterTestCase', \false);
