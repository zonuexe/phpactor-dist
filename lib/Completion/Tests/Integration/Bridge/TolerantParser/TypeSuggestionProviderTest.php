<?php

namespace Phpactor202301\Phpactor\Completion\Tests\Integration\Bridge\TolerantParser;

use Phpactor202301\DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use Generator;
use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Completion\Bridge\TolerantParser\TypeSuggestionProvider;
use Phpactor202301\Phpactor\Completion\Core\Suggestion;
use Phpactor202301\Phpactor\Name\FullyQualifiedName;
use Phpactor202301\Phpactor\ReferenceFinder\Search\NameSearchResult;
use Phpactor202301\Phpactor\ReferenceFinder\Search\PredefinedNameSearcher;
use Phpactor202301\Phpactor\TestUtils\ExtractOffset;
class TypeSuggestionProviderTest extends TestCase
{
    use ArraySubsetAsserts;
    /**
     * @dataProvider provideProvide
     * @param array<string> $expected
     */
    public function testProvide(string $source, string $search, array $expected) : void
    {
        $searcher = new PredefinedNameSearcher([NameSearchResult::create('class', FullyQualifiedName::fromString('Phpactor202301\\Namespace\\Aardvark'))]);
        [$source, $offset] = ExtractOffset::fromSource($source);
        $node = (new Parser())->parseSourceFile($source)->getDescendantNodeAtPosition((int) $offset);
        $suggestions = \iterator_to_array((new TypeSuggestionProvider($searcher))->provide($node, $search));
        self::assertArraySubset($expected, \array_map(fn(Suggestion $s) => $s->name(), $suggestions));
    }
    /**
     * @return Generator<mixed>
     */
    public function provideProvide() : Generator
    {
        (yield ['<?php <>', '', []]);
        (yield 'imported name' => ['<?php use Foobar; new bar();<>', 'F', ['Foobar']]);
        (yield 'scalar' => ['', '', ['string', 'float', 'int']]);
        (yield 'generic' => ['', 'Foo<s', ['string']]);
        (yield 'union' => ['', 'Foo|', ['string']]);
        (yield 'intersection' => ['', 'Foo&', ['string']]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Completion\\Tests\\Integration\\Bridge\\TolerantParser\\TypeSuggestionProviderTest', 'Phpactor\\Completion\\Tests\\Integration\\Bridge\\TolerantParser\\TypeSuggestionProviderTest', \false);
