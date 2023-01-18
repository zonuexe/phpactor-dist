<?php

namespace Phpactor202301;

use Phpactor202301\Foobar\Example as BadExample;
class Example extends BadExample
{
}
\class_alias('Phpactor202301\\Example', 'Example', \false);
