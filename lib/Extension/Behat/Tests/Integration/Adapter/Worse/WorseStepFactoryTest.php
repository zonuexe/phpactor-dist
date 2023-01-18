<?php

namespace Phpactor202301\Phpactor\Extension\Behat\Tests\Integration\Adapter\Worse;

use Phpactor202301\PHPUnit\Framework\TestCase;
use Phpactor202301\Phpactor\Extension\Behat\Adapter\Worse\WorseContextClassResolver;
use Phpactor202301\Phpactor\Extension\Behat\Adapter\Worse\WorseStepFactory;
use Phpactor202301\Phpactor\Extension\Behat\Behat\Context;
use Phpactor202301\Phpactor\Extension\Behat\Behat\Step;
use Phpactor202301\Phpactor\Extension\Behat\Behat\StepParser;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode;
use Phpactor202301\Phpactor\WorseReflection\ReflectorBuilder;
class WorseStepFactoryTest extends TestCase
{
    public function testGeneratesSteps() : void
    {
        $path = __DIR__ . '/TestContext.php';
        $reflector = ReflectorBuilder::create()->addSource(SourceCode::fromPathAndString($path, (string) \file_get_contents($path)))->build();
        $stepGenerator = new WorseStepFactory($reflector, new WorseContextClassResolver($reflector));
        $parser = new StepParser();
        $context = new Context('default', TestContext::class);
        $steps = \iterator_to_array($stepGenerator->generate($parser, [$context]));
        $this->assertEquals([new Step($context, 'givenThatThis', 'that I visit Berlin', $path, 150), new Step($context, 'shouldRun', 'I should run to Weisensee', $path, 260)], $steps);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Behat\\Tests\\Integration\\Adapter\\Worse\\WorseStepFactoryTest', 'Phpactor\\Extension\\Behat\\Tests\\Integration\\Adapter\\Worse\\WorseStepFactoryTest', \false);
