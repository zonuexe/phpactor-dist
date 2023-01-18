<?php

namespace Phpactor202301\Acme;

use Phpactor202301\Acme\ClassMover\RefFinder\RefFinder\TolerantRefFinder;
class Hello
{
    public function something() : void
    {
        TolerantRefFinder::foobar();
    }
}
