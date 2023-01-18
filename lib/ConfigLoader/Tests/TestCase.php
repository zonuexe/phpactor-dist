<?php

namespace Phpactor202301\Phpactor\ConfigLoader\Tests;

use Phpactor202301\PHPUnit\Framework\TestCase as PhpunitTestCase;
use Phpactor202301\Phpactor\TestUtils\Workspace;
class TestCase extends PhpunitTestCase
{
    protected Workspace $workspace;
    public function setUp() : void
    {
        $this->workspace = Workspace::create(__DIR__ . '/Workspace');
        $this->workspace->reset();
    }
}
\class_alias('Phpactor202301\\Phpactor\\ConfigLoader\\Tests\\TestCase', 'Phpactor\\ConfigLoader\\Tests\\TestCase', \false);
