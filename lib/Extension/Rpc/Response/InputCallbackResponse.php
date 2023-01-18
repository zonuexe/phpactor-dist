<?php

namespace Phpactor202301\Phpactor\Extension\Rpc\Response;

use Phpactor202301\Phpactor\Extension\Rpc\Response;
use Phpactor202301\Phpactor\Extension\Rpc\Request;
use Phpactor202301\Phpactor\Extension\Rpc\Response\Input\Input;
class InputCallbackResponse implements Response
{
    private array $inputs = [];
    private function __construct(private Request $callbackAction, array $inputs)
    {
        foreach ($inputs as $input) {
            $this->add($input);
        }
    }
    public static function fromCallbackAndInputs(Request $callbackAction, array $inputs)
    {
        return new self($callbackAction, $inputs);
    }
    public function name() : string
    {
        return 'input_callback';
    }
    public function inputs() : array
    {
        return $this->inputs;
    }
    public function parameters() : array
    {
        return ['inputs' => \array_map(function (Input $input) {
            return ['name' => $input->name(), 'type' => $input->type(), 'parameters' => $input->parameters()];
        }, $this->inputs), 'callback' => ['action' => $this->callbackAction->name(), 'parameters' => $this->callbackAction->parameters()]];
    }
    public function callbackAction() : Request
    {
        return $this->callbackAction;
    }
    private function add(Input $input) : void
    {
        $this->inputs[] = $input;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\Response\\InputCallbackResponse', 'Phpactor\\Extension\\Rpc\\Response\\InputCallbackResponse', \false);
