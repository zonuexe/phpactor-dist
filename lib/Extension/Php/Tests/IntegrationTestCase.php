<?php

namespace Phpactor202301\Phpactor\Extension\Php\Tests;

use Phpactor202301\Phpactor\TestUtils\PHPUnit\TestCase;
use Phpactor202301\Phpactor\TestUtils\Workspace;
class IntegrationTestCase extends TestCase
{
    public function workspace() : Workspace
    {
        return Workspace::create(__DIR__ . '/Workspace');
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Php\\Tests\\IntegrationTestCase', 'Phpactor\\Extension\\Php\\Tests\\IntegrationTestCase', \false);
