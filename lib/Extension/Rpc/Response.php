<?php

namespace Phpactor202301\Phpactor\Extension\Rpc;

interface Response
{
    public function name() : string;
    public function parameters() : array;
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\Response', 'Phpactor\\Extension\\Rpc\\Response', \false);
