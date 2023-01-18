<?php

namespace Phpactor202301\Phpactor\Extension\Rpc\Response;

use Phpactor202301\Phpactor\Extension\Rpc\Response;
/**
 * Instruct the editor to return the value to the RPC caller.
 *
 * NOTE: No actions can be performed after this action.
 */
class ReturnResponse implements Response
{
    private function __construct(private $value)
    {
    }
    public function name() : string
    {
        return 'return';
    }
    public function parameters() : array
    {
        return ['value' => $this->value];
    }
    public static function fromValue($value) : ReturnResponse
    {
        return new self($value);
    }
    public function value()
    {
        return $this->value;
    }
}
/**
 * Instruct the editor to return the value to the RPC caller.
 *
 * NOTE: No actions can be performed after this action.
 */
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\Response\\ReturnResponse', 'Phpactor\\Extension\\Rpc\\Response\\ReturnResponse', \false);
