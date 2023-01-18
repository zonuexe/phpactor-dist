<?php

namespace Phpactor202301\Phpactor\ClassMover\Tests\Adapter\TolerantParser;

class Example7
{
    public function build() : Example7
    {
        return new self();
    }
}
\class_alias('Phpactor202301\\Phpactor\\ClassMover\\Tests\\Adapter\\TolerantParser\\Example7', 'Phpactor\\ClassMover\\Tests\\Adapter\\TolerantParser\\Example7', \false);
