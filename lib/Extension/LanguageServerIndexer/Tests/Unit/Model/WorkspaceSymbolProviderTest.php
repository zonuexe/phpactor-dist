<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerIndexer\Tests\Unit\Model;

use Closure;
use Generator;
use Phpactor202301\Phpactor\Extension\LanguageServerIndexer\LanguageServerIndexerExtension;
use Phpactor202301\Phpactor\Extension\LanguageServerIndexer\Model\WorkspaceSymbolProvider;
use Phpactor202301\Phpactor\Extension\LanguageServerIndexer\Tests\IntegrationTestCase;
use Phpactor202301\Phpactor\Indexer\Model\Indexer;
use Phpactor202301\Phpactor\Indexer\Model\SearchClient;
use Phpactor202301\Phpactor\LanguageServerProtocol\SymbolInformation;
use Phpactor202301\Phpactor\LanguageServerProtocol\SymbolKind;
use Phpactor202301\Phpactor\TextDocument\TextDocumentLocator;
use function Phpactor202301\Amp\Promise\wait;
class WorkspaceSymbolProviderTest extends IntegrationTestCase
{
    protected function setUp() : void
    {
        $this->workspace()->reset();
    }
    /**
     * @dataProvider provideProvide
     */
    public function testProvide(array $workspace, Closure $assertion, string $query, int $limit = 250) : void
    {
        $container = $this->container([LanguageServerIndexerExtension::WORKSPACE_SYMBOL_SEARCH_LIMIT => $limit]);
        foreach ($workspace as $path => $contents) {
            $this->workspace()->put($path, $contents);
        }
        $indexer = $container->get(Indexer::class);
        \assert($indexer instanceof Indexer);
        $indexer->getJob()->run();
        $client = $container->get(SearchClient::class);
        $locator = $container->get(TextDocumentLocator::class);
        $provider = new WorkspaceSymbolProvider($client, $locator, $limit);
        $informations = wait($provider->provideFor($query));
        $assertion($informations);
    }
    /**
     * @return Generator<mixed>
     */
    public function provideProvide() : Generator
    {
        (yield 'No matches' => [['Foo.php' => '<?php class Foo'], function (array $infos) : void {
            self::assertCount(0, $infos);
        }, 'Nothing']);
        (yield 'Class' => [['Foo1.php' => '<?php class Foo'], function (array $infos) : void {
            self::assertCount(1, $infos);
            $info = \reset($infos);
            \assert($info instanceof SymbolInformation);
            self::assertEquals('Foo', $info->name);
            self::assertEquals(SymbolKind::CLASS_, $info->kind);
        }, 'F']);
        (yield 'Methods not currently supported' => [['Foo.php' => '<?php class Foo { function barbar() {} }'], function (array $infos) : void {
            self::assertCount(0, $infos);
        }, 'bar']);
        (yield 'Functions' => [['Foo.php' => '<?php function barbar(){}'], function (array $infos) : void {
            self::assertCount(1, $infos);
            $info = \reset($infos);
            \assert($info instanceof SymbolInformation);
            self::assertEquals('barbar', $info->name);
            self::assertEquals(SymbolKind::FUNCTION, $info->kind);
        }, 'bar']);
        (yield 'Constants' => [['Foo4.php' => '<?php const FOOBAR = "barfoo"'], function (array $infos) : void {
            self::assertCount(1, $infos);
            $info = \reset($infos);
            \assert($info instanceof SymbolInformation);
            self::assertEquals('FOOBAR', $info->name);
            self::assertEquals(SymbolKind::CONSTANT, $info->kind);
        }, 'Foo']);
        (yield 'Applies a limit' => [['Foo5.php' => '<?php const FOOBAR = "barfoo"', 'Foo6.php' => '<?php const FOOBAZ = "barfoo"', 'Foo7.php' => '<?php const FOOBAL = "barfoo"'], function (array $infos) : void {
            self::assertCount(2, $infos);
        }, 'Foo', 2]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerIndexer\\Tests\\Unit\\Model\\WorkspaceSymbolProviderTest', 'Phpactor\\Extension\\LanguageServerIndexer\\Tests\\Unit\\Model\\WorkspaceSymbolProviderTest', \false);
