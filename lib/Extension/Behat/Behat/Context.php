<?php

namespace Phpactor202301\Phpactor\Extension\Behat\Behat;

class Context
{
    public function __construct(private string $suite, private string $class)
    {
    }
    public function class() : string
    {
        return $this->class;
    }
    public function suite() : string
    {
        return $this->suite;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Behat\\Behat\\Context', 'Phpactor\\Extension\\Behat\\Behat\\Context', \false);
