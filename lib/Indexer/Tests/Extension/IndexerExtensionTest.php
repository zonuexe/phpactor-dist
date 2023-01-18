<?php

namespace Phpactor202301\Phpactor\Indexer\Tests\Extension;

use Phpactor202301\Phpactor\AmpFsWatch\Watcher;
use Phpactor202301\Phpactor\AmpFsWatch\Watcher\Null\NullWatcher;
use Phpactor202301\Phpactor\Extension\ReferenceFinder\ReferenceFinderExtension;
use Phpactor202301\Phpactor\Extension\Rpc\Request;
use Phpactor202301\Phpactor\Extension\Rpc\RequestHandler;
use Phpactor202301\Phpactor\Extension\Rpc\Response\EchoResponse;
use Phpactor202301\Phpactor\Extension\Rpc\RpcExtension;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor202301\Phpactor\Indexer\Extension\IndexerExtension;
use Phpactor202301\Phpactor\Indexer\Model\Indexer;
use Phpactor202301\Phpactor\Indexer\Tests\IntegrationTestCase;
use Phpactor202301\Phpactor\ReferenceFinder\ChainImplementationFinder;
use Phpactor202301\Phpactor\ReferenceFinder\ChainReferenceFinder;
use Phpactor202301\Phpactor\ReferenceFinder\ReferenceFinder;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClass;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
use RuntimeException;
use function iterator_to_array;
class IndexerExtensionTest extends IntegrationTestCase
{
    protected function setUp() : void
    {
        $this->initProject();
    }
    public function testReturnsImplementationFinder() : void
    {
        $container = $this->container();
        $finder = $container->get(ReferenceFinderExtension::SERVICE_IMPLEMENTATION_FINDER);
        self::assertInstanceOf(ChainImplementationFinder::class, $finder);
    }
    public function testReturnsReferenceFinder() : void
    {
        $container = $this->container();
        $finder = $container->get(ReferenceFinder::class);
        self::assertInstanceOf(ChainReferenceFinder::class, $finder);
    }
    public function testBuildIndex() : void
    {
        $container = $this->container();
        $indexer = $container->get(Indexer::class);
        $this->assertInstanceOf(Indexer::class, $indexer);
        $indexer->getJob()->run();
    }
    public function testIndexDirtyFile() : void
    {
        $container = $this->container();
        $indexer = $container->get(Indexer::class);
        $this->assertInstanceOf(Indexer::class, $indexer);
        \assert($indexer instanceof Indexer);
        $this->workspace()->put('foo', 'asd');
        $indexer->indexDirty(TextDocumentBuilder::create('<?php echo "Hello!";')->uri($this->workspace()->path('foo'))->build());
        $files = iterator_to_array($indexer->getJob()->generator());
        $lastFile = \array_pop($files);
        self::assertEquals($this->workspace()->path('foo'), $lastFile, 'Dirty file was included in job');
        $files = iterator_to_array($indexer->getJob()->generator());
        $lastFile = \array_pop($files);
        self::assertNotEquals($this->workspace()->path('foo'), $lastFile, 'Dirty file was not included again');
    }
    public function testRpcHandler() : void
    {
        $container = $this->container();
        $handler = $container->get(RpcExtension::SERVICE_REQUEST_HANDLER);
        \assert($handler instanceof RequestHandler);
        $request = Request::fromNameAndParameters('index', []);
        $response = $handler->handle($request);
        self::assertInstanceOf(EchoResponse::class, $response);
        self::assertMatchesRegularExpression('{Indexed [0-9]+ files}', $response->message());
    }
    public function testThrowsExceptionIfEnabledWatcherDoesntExist() : void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unknown watchers "foobar" specified, available watchers: ');
        $container = $this->container([IndexerExtension::PARAM_ENABLED_WATCHERS => ['foobar']]);
        $container->get(Watcher::class);
    }
    public function testUseNullWatcherIfEnabledWatchersIsEmpty() : void
    {
        $container = $this->container([IndexerExtension::PARAM_ENABLED_WATCHERS => []]);
        self::assertInstanceOf(NullWatcher::class, $container->get(Watcher::class));
    }
    public function testSourceLocator() : void
    {
        $this->initProject();
        $container = $this->container();
        $indexer = $container->get(Indexer::class);
        \assert($indexer instanceof Indexer);
        $indexer->reset();
        $indexer->getJob()->run();
        $reflector = $container->get(WorseReflectionExtension::SERVICE_REFLECTOR);
        \assert($reflector instanceof Reflector);
        $class = $reflector->reflectClass('ClassWithWrongName');
        self::assertInstanceOf(ReflectionClass::class, $class);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Tests\\Extension\\IndexerExtensionTest', 'Phpactor\\Indexer\\Tests\\Extension\\IndexerExtensionTest', \false);
