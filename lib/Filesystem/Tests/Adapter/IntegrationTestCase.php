<?php

namespace Phpactor202301\Phpactor\Filesystem\Tests\Adapter;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Symfony\Component\Filesystem\Filesystem;
abstract class IntegrationTestCase extends TestCase
{
    protected function initWorkspace() : void
    {
        $filesystem = new Filesystem();
        if ($filesystem->exists($this->workspacePath())) {
            $filesystem->remove($this->workspacePath());
        }
        $filesystem->mkdir($this->workspacePath());
    }
    protected function workspacePath()
    {
        return \realpath(__DIR__ . '/..') . '/Workspace';
    }
    protected function loadProject() : void
    {
        $projectPath = __DIR__ . '/project';
        $filesystem = new Filesystem();
        $filesystem->mirror($projectPath, $this->workspacePath());
        \chdir($this->workspacePath());
        \exec('composer dumpautoload 2> /dev/null');
    }
    protected function getProjectAutoloader()
    {
        return require __DIR__ . '/project/vendor/autoload.php';
    }
}
\class_alias('Phpactor202301\\Phpactor\\Filesystem\\Tests\\Adapter\\IntegrationTestCase', 'Phpactor\\Filesystem\\Tests\\Adapter\\IntegrationTestCase', \false);
