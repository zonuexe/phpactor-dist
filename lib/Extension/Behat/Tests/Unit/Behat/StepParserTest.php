<?php

namespace Phpactor202301\Phpactor\Extension\Behat\Tests\Unit\Behat;

use Generator;
use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\Behat\Behat\StepParser;
class StepParserTest extends TestCase
{
    /**
     * @dataProvider provideSteps
     * @param array<int,string> $expected
     */
    public function testParsesPhpStepsDefinitions(string $docblock, array $expected) : void
    {
        $parser = new StepParser();
        $steps = $parser->parseSteps($docblock);
        $this->assertEquals($expected, $steps);
    }
    /**
     * @return Generator<array{string,array<int,string>}>
     */
    public function provideSteps() : Generator
    {
        (yield ['* @Given I visit Berlin', ['I visit Berlin']]);
        (yield [<<<'EOT'
/**
 * @Given I visit Berlin
 * @And I go to Alexanderplatz
 * @When climb up the Fernsehturm
 * @Then I will see things
 * @But I will not know what they are
 */
EOT
, ['I visit Berlin', 'I go to Alexanderplatz', 'climb up the Fernsehturm', 'I will see things', 'I will not know what they are']]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Behat\\Tests\\Unit\\Behat\\StepParserTest', 'Phpactor\\Extension\\Behat\\Tests\\Unit\\Behat\\StepParserTest', \false);
