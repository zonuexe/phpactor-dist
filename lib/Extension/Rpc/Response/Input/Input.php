<?php

namespace Phpactor202301\Phpactor\Extension\Rpc\Response\Input;

interface Input
{
    public function type() : string;
    public function name() : string;
    public function parameters() : array;
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\Response\\Input\\Input', 'Phpactor\\Extension\\Rpc\\Response\\Input\\Input', \false);
