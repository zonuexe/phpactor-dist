<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerPhpstan\Tests;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\TestUtils\Workspace;
abstract class IntegrationTestCase extends TestCase
{
    protected function workspace() : Workspace
    {
        return Workspace::create(__DIR__ . '/Workspace');
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerPhpstan\\Tests\\IntegrationTestCase', 'Phpactor\\Extension\\LanguageServerPhpstan\\Tests\\IntegrationTestCase', \false);
