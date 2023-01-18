<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerPsalm\Tests;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\TestUtils\Workspace;
abstract class IntegrationTestCase extends TestCase
{
    protected function tearDown() : void
    {
        //        $this->workspace()->reset();
    }
    protected function workspace() : Workspace
    {
        return Workspace::create(__DIR__ . '/Workspace');
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerPsalm\\Tests\\IntegrationTestCase', 'Phpactor\\Extension\\LanguageServerPsalm\\Tests\\IntegrationTestCase', \false);
