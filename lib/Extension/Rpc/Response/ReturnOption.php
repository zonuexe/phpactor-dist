<?php

namespace Phpactor202301\Phpactor\Extension\Rpc\Response;

class ReturnOption
{
    private function __construct(private string $name, private $value)
    {
    }
    public static function fromNameAndValue(string $name, $value)
    {
        return new self($name, $value);
    }
    public function name() : string
    {
        return $this->name;
    }
    public function value()
    {
        return $this->value;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\Response\\ReturnOption', 'Phpactor\\Extension\\Rpc\\Response\\ReturnOption', \false);
