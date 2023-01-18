<?php

namespace Phpactor202301\Phpactor\Extension\Behat\Behat;

use Generator;
use IteratorAggregate;
/**
 * @implements IteratorAggregate<Step>
 */
class StepGenerator implements IteratorAggregate
{
    public function __construct(private BehatConfig $config, private StepFactory $factory, private StepParser $parser)
    {
    }
    public function getIterator() : Generator
    {
        yield from $this->factory->generate($this->parser, $this->config->contexts());
    }
}
/**
 * @implements IteratorAggregate<Step>
 */
\class_alias('Phpactor202301\\Phpactor\\Extension\\Behat\\Behat\\StepGenerator', 'Phpactor\\Extension\\Behat\\Behat\\StepGenerator', \false);
