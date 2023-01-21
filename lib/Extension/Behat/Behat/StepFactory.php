<?php

namespace Phpactor\Extension\Behat\Behat;

use Generator;
interface StepFactory
{
    /**
     * @param Context[] $contexts
     */
    public function generate(\Phpactor\Extension\Behat\Behat\StepParser $parser, array $contexts) : Generator;
}
