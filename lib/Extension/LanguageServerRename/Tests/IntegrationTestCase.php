<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerRename\Tests;

use Phpactor202301\Phpactor\Extension\LanguageServerBridge\LanguageServerBridgeExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerRename\LanguageServerRenameExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerRename\Tests\Extension\TestExtension;
use Phpactor202301\Phpactor\Extension\LanguageServer\LanguageServerExtension;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\ReferenceFinder\ReferenceFinderExtension;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
use Phpactor202301\Phpactor\Container\PhpactorContainer;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\TestUtils\PHPUnit\TestCase;
use Phpactor202301\Phpactor\TestUtils\Workspace;
class IntegrationTestCase extends TestCase
{
    protected function setUp() : void
    {
        $this->workspace()->reset();
    }
    protected function workspace() : Workspace
    {
        return Workspace::create(__DIR__ . '/Workspace');
    }
    protected function container(array $config = []) : Container
    {
        $container = PhpactorContainer::fromExtensions([LanguageServerExtension::class, TestExtension::class, LanguageServerRenameExtension::class, FilePathResolverExtension::class, LanguageServerBridgeExtension::class, LoggingExtension::class, ReferenceFinderExtension::class], $config);
        return $container;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerRename\\Tests\\IntegrationTestCase', 'Phpactor\\Extension\\LanguageServerRename\\Tests\\IntegrationTestCase', \false);
