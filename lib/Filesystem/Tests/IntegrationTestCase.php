<?php

namespace Phpactor202301\Phpactor\Filesystem\Tests;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\TestUtils\Workspace;
class IntegrationTestCase extends TestCase
{
    protected function workspace() : Workspace
    {
        return new Workspace(__DIR__ . '/Workspace');
    }
}
\class_alias('Phpactor202301\\Phpactor\\Filesystem\\Tests\\IntegrationTestCase', 'Phpactor\\Filesystem\\Tests\\IntegrationTestCase', \false);
