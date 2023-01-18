<?php

namespace Phpactor202301\Phpactor\Extension\Behat\Behat;

use Generator;
interface StepFactory
{
    /**
     * @param Context[] $contexts
     */
    public function generate(StepParser $parser, array $contexts) : Generator;
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Behat\\Behat\\StepFactory', 'Phpactor\\Extension\\Behat\\Behat\\StepFactory', \false);
