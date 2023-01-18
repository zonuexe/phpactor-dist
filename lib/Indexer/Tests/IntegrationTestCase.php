<?php

namespace Phpactor202301\Phpactor\Indexer\Tests;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\ReferenceFinder\ReferenceFinderExtension;
use Phpactor202301\Phpactor\Extension\ComposerAutoloader\ComposerAutoloaderExtension;
use Phpactor202301\Phpactor\Extension\Rpc\RpcExtension;
use Phpactor202301\Phpactor\Extension\ClassToFile\ClassToFileExtension;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor202301\Phpactor\Extension\SourceCodeFilesystem\SourceCodeFilesystemExtension;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
use Phpactor202301\Phpactor\Extension\Console\ConsoleExtension;
use Phpactor202301\Phpactor\Container\PhpactorContainer;
use Phpactor202301\Phpactor\Indexer\Adapter\Worse\WorseRecordReferenceEnhancer;
use Phpactor202301\Phpactor\Indexer\Extension\IndexerExtension;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Indexer\IndexAgentBuilder;
use Phpactor202301\Phpactor\Indexer\Model\QueryClient;
use Phpactor202301\Phpactor\Indexer\Model\TestIndexAgent;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
use Phpactor202301\Phpactor\TestUtils\Workspace;
use Phpactor202301\Phpactor\Indexer\Model\Index;
use Phpactor202301\Psr\Log\AbstractLogger;
use Phpactor202301\Psr\Log\LoggerInterface;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCodeLocator\StubSourceLocator;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
use Phpactor202301\Symfony\Component\Process\Process;
class IntegrationTestCase extends TestCase
{
    protected function workspace() : Workspace
    {
        return Workspace::create(__DIR__ . '/Workspace');
    }
    protected function initProject() : void
    {
        $this->workspace()->loadManifest((string) \file_get_contents(__DIR__ . '/Adapter/Manifest/buildIndex.php.test'));
        $process = new Process(['composer', 'install'], $this->workspace()->path('/'));
        $process->mustRun();
    }
    protected function indexAgent() : TestIndexAgent
    {
        return $this->indexAgentBuilder()->buildTestAgent();
    }
    protected function indexAgentBuilder(string $path = 'project') : IndexAgentBuilder
    {
        return IndexAgentBuilder::create($this->workspace()->path('repo'), $this->workspace()->path($path))->setReferenceEnhancer(new WorseRecordReferenceEnhancer($this->createReflector(), $this->createLogger()));
    }
    protected function buildIndex(?Index $index = null) : Index
    {
        $agent = $this->indexAgent();
        $agent->indexer()->getJob()->run();
        return $agent->index();
    }
    protected function createReflector() : Reflector
    {
        return ReflectorBuilder::create()->addLocator(new StubSourceLocator(ReflectorBuilder::create()->build(), $this->workspace()->path('/'), $this->workspace()->path('/')))->build();
    }
    protected function indexQuery(Index $index) : QueryClient
    {
        return new QueryClient($index, new WorseRecordReferenceEnhancer($this->createReflector(), $this->createLogger()));
    }
    protected function container(array $config = []) : Container
    {
        $key = \serialize($config);
        static $container = [];
        if (isset($container[$key])) {
            return $container[$key];
        }
        $container[$key] = PhpactorContainer::fromExtensions([ConsoleExtension::class, IndexerExtension::class, FilePathResolverExtension::class, LoggingExtension::class, SourceCodeFilesystemExtension::class, WorseReflectionExtension::class, ClassToFileExtension::class, RpcExtension::class, ComposerAutoloaderExtension::class, ReferenceFinderExtension::class], \array_merge([FilePathResolverExtension::PARAM_APPLICATION_ROOT => __DIR__ . '/../', FilePathResolverExtension::PARAM_PROJECT_ROOT => $this->workspace()->path(), IndexerExtension::PARAM_INDEX_PATH => $this->workspace()->path('/cache'), LoggingExtension::PARAM_ENABLED => \true, LoggingExtension::PARAM_PATH => 'php://stderr', WorseReflectionExtension::PARAM_ENABLE_CACHE => \false, WorseReflectionExtension::PARAM_STUB_DIR => $this->workspace()->path()], $config));
        return $container[$key];
    }
    private function createLogger() : LoggerInterface
    {
        return new class extends AbstractLogger
        {
            public function log($level, $message, array $context = []) : void
            {
                \fwrite(\STDOUT, \sprintf("[%s] %s\n", $level, $message));
            }
        };
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Tests\\IntegrationTestCase', 'Phpactor\\Indexer\\Tests\\IntegrationTestCase', \false);
