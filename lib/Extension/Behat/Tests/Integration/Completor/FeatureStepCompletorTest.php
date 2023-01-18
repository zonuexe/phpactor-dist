<?php

namespace Phpactor202301\Phpactor\Extension\Behat\Tests\Integration\Completor;

use Phpactor202301\DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use Generator;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Completion\Core\Completor;
use Phpactor202301\Phpactor\Container\PhpactorContainer;
use Phpactor202301\Phpactor\Extension\Behat\BehatExtension;
use Phpactor202301\Phpactor\Extension\ClassToFile\ClassToFileExtension;
use Phpactor202301\Phpactor\Extension\Completion\CompletionExtension;
use Phpactor202301\Phpactor\Extension\ComposerAutoloader\ComposerAutoloaderExtension;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
use Phpactor202301\Phpactor\Extension\Logger\LoggingExtension;
use Phpactor202301\Phpactor\Extension\WorseReflection\WorseReflectionExtension;
use Phpactor202301\Phpactor\TestUtils\ExtractOffset;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
class FeatureStepCompletorTest extends TestCase
{
    use ArraySubsetAsserts;
    /**
     * @dataProvider provideComplete
     * @param array<int,array<string,mixed>> $expected
     */
    public function testComplete(string $source, array $expected) : void
    {
        [$source, $start, $end] = ExtractOffset::fromSource($source);
        $suggestions = \iterator_to_array($this->completor()->complete(TextDocumentBuilder::create($source)->language('gherkin')->build(), ByteOffset::fromInt((int) $end)));
        foreach ($expected as $index => $expectation) {
            $this->assertArraySubset($expectation, $suggestions[$index]->toArray());
        }
    }
    /**
     * @return Generator<string,array{string,array<int,array<string,mixed>>}>
     */
    public function provideComplete() : Generator
    {
        (yield 'all' => [<<<'EOT'
Feature: Foobar

    Scenario: Hello
        Given <><>
EOT
, [['type' => 'snippet', 'name' => 'that I visit Berlin', 'short_description' => ExampleContext::class, 'range' => [51, 51]], ['type' => 'snippet', 'name' => 'I should run to Weisensee', 'short_description' => ExampleContext::class, 'range' => [51, 51]]]]);
        (yield 'partial match' => [<<<'EOT'
Feature: Foobar

    Scenario: Hello
        Given <>that I visit<>
EOT
, [['type' => 'snippet', 'name' => ' Berlin', 'label' => 'that I visit Berlin', 'short_description' => ExampleContext::class, 'range' => [51, 63]]]]);
    }
    private function completor() : Completor
    {
        $container = PhpactorContainer::fromExtensions([WorseReflectionExtension::class, FilePathResolverExtension::class, CompletionExtension::class, BehatExtension::class, ClassToFileExtension::class, ComposerAutoloaderExtension::class, LoggingExtension::class], [FilePathResolverExtension::PARAM_APPLICATION_ROOT => __DIR__ . '/../../../../../..', BehatExtension::PARAM_CONFIG_PATH => __DIR__ . '/behat.yml']);
        return $container->get(CompletionExtension::SERVICE_REGISTRY)->completorForType('cucumber');
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Behat\\Tests\\Integration\\Completor\\FeatureStepCompletorTest', 'Phpactor\\Extension\\Behat\\Tests\\Integration\\Completor\\FeatureStepCompletorTest', \false);
