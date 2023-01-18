<?php

namespace Phpactor202301\Phpactor\Extension\Behat\Tests\Unit\ReferenceFinder;

use Generator;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\Behat\Behat\Context;
use Phpactor202301\Phpactor\Extension\Behat\Behat\Step;
use Phpactor202301\Phpactor\Extension\Behat\Behat\StepGenerator;
use Phpactor202301\Phpactor\Extension\Behat\Behat\StepParser;
use Phpactor202301\Phpactor\Extension\Behat\ReferenceFinder\StepDefinitionLocator;
use Phpactor202301\Phpactor\TestUtils\ExtractOffset;
use Phpactor202301\Phpactor\TextDocument\ByteOffset;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
use Phpactor202301\Prophecy\PhpUnit\ProphecyTrait;
use Phpactor202301\Prophecy\Prophecy\ObjectProphecy;
class StepDefinitionLocatorTest extends TestCase
{
    use ProphecyTrait;
    const EXAMPLE_PATH = '/path/to.php';
    const EXAMPLE_OFFSET = 6666;
    private StepDefinitionLocator $locator;
    /**
     * @var ObjectProphecy<StepGenerator>
     */
    private ObjectProphecy $generator;
    public function setUp() : void
    {
        $this->generator = $this->prophesize(StepGenerator::class);
        $this->locator = new StepDefinitionLocator($this->generator->reveal(), new StepParser());
    }
    /**
     * @dataProvider provideLocateDefinition
     */
    public function testLocateDefinition(string $step) : void
    {
        $this->generator->getIterator()->will(function () use($step) {
            (yield new Step(new Context('foo', 'bar'), 'myMethod', $step, self::EXAMPLE_PATH, self::EXAMPLE_OFFSET));
        });
        $text = <<<'EOT'
Feature: Hello

    Scenario: Something
        Given I have a scenario step
        And my <>name is "Daniel"
        When I jump to it's definition
        Then my cursor should be on the step definition
EOT;
        [$text, $offset] = ExtractOffset::fromSource($text);
        $document = TextDocumentBuilder::create($text)->language('cucumber')->build();
        $offset = ByteOffset::fromInt((int) $offset);
        $location = $this->locator->locateDefinition($document, $offset);
        $this->assertEquals(self::EXAMPLE_PATH, $location->first()->location()->uri()->path());
        $this->assertEquals(self::EXAMPLE_OFFSET, $location->first()->location()->offset()->toInt());
    }
    /**
     * @return Generator<int|string,array{string}>
     */
    public function provideLocateDefinition() : Generator
    {
        (yield ['my name is ":name"']);
        (yield 'regex' => ['/my name is "\\w+"/']);
        (yield 'turnip' => ['my name(s) is ":name"']);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Behat\\Tests\\Unit\\ReferenceFinder\\StepDefinitionLocatorTest', 'Phpactor\\Extension\\Behat\\Tests\\Unit\\ReferenceFinder\\StepDefinitionLocatorTest', \false);
