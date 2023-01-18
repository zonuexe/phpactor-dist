<?php

namespace Phpactor202301\Phpactor\DocblockParser;

use Phpactor202301\Phpactor\DocblockParser\Ast\Node;
interface Printer
{
    public function print(Node $node) : string;
}
\class_alias('Phpactor202301\\Phpactor\\DocblockParser\\Printer', 'Phpactor\\DocblockParser\\Printer', \false);
