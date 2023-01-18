<?php

namespace Phpactor202301\Phpactor\Extension\ContextMenu\Model;

class Action
{
    public function __construct(private string $action, private ?string $key = null, private array $parameters = [])
    {
    }
    public function action() : string
    {
        return $this->action;
    }
    public function parameters() : array
    {
        return $this->parameters;
    }
    public function key() : ?string
    {
        return $this->key;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\ContextMenu\\Model\\Action', 'Phpactor\\Extension\\ContextMenu\\Model\\Action', \false);
