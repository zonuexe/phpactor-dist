<?php

namespace Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\TolerantParser;

use Phpactor202301\Phpactor\CodeTransform\Tests\Adapter\AdapterTestCase;
use Phpactor202301\Microsoft\PhpParser\Parser;
class TolerantTestCase extends AdapterTestCase
{
    public function parser() : Parser
    {
        return new Parser();
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Tests\\Adapter\\TolerantParser\\TolerantTestCase', 'Phpactor\\CodeTransform\\Tests\\Adapter\\TolerantParser\\TolerantTestCase', \false);
