<?php

namespace Phpactor\Extension\Behat\Behat;

use Generator;
use IteratorAggregate;
/**
 * @implements IteratorAggregate<Step>
 */
class StepGenerator implements IteratorAggregate
{
    public function __construct(private \Phpactor\Extension\Behat\Behat\BehatConfig $config, private \Phpactor\Extension\Behat\Behat\StepFactory $factory, private \Phpactor\Extension\Behat\Behat\StepParser $parser)
    {
    }
    public function getIterator() : Generator
    {
        yield from $this->factory->generate($this->parser, $this->config->contexts());
    }
}
