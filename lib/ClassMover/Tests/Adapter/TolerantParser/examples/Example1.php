<?php

namespace Phpactor202301\Acme;

use Phpactor202301\Acme\Foobar\Warble;
use Phpactor202301\Acme\Foobar\Barfoo;
use Phpactor202301\Acme\Barfoo as ZedZed;
class Hello
{
    public function something() : void
    {
        $foo = new Warble();
        $bar = new Demo();
        //this should not be found as it is de-referenced (we wil replace the use statement instead)
        ZedZed::something();
        \assert(Barfoo::class === 'Foo');
        Barfoo::foobar();
    }
}
