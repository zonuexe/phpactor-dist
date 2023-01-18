<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerBridge\Tests;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\TestUtils\Workspace;
class IntegrationTestCase extends TestCase
{
    protected function workspace() : Workspace
    {
        return Workspace::create(__DIR__ . '/Workspace');
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerBridge\\Tests\\IntegrationTestCase', 'Phpactor\\Extension\\LanguageServerBridge\\Tests\\IntegrationTestCase', \false);
