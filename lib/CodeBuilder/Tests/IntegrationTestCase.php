<?php

namespace Phpactor202301\Phpactor\CodeBuilder\Tests;

use Generator;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\TestUtils\Workspace;
use RuntimeException;
abstract class IntegrationTestCase extends TestCase
{
    public function workspace() : Workspace
    {
        return Workspace::create(__DIR__ . '/Workspace');
    }
    protected function yieldExamplesIn(string $path) : Generator
    {
        if (!\file_exists($path)) {
            throw new RuntimeException(\sprintf('Directory "%s" does not exist', $path));
        }
        foreach (\glob($path . '/*.test.php') as $filename) {
            (yield \basename($filename) => [$filename]);
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeBuilder\\Tests\\IntegrationTestCase', 'Phpactor\\CodeBuilder\\Tests\\IntegrationTestCase', \false);
