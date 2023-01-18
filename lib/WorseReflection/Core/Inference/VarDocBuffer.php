<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference;

use Phpactor202301\Phpactor\WorseReflection\Core\Type;
class VarDocBuffer
{
    /**
     * @var array<string,Type>
     */
    private array $buffer = [];
    private int $version = 0;
    public function set(string $name, Type $type) : void
    {
        $this->version++;
        $this->buffer[$name] = $type;
    }
    public function yank(string $name) : ?Type
    {
        if (!isset($this->buffer[$name])) {
            return null;
        }
        $type = $this->buffer[$name];
        unset($this->buffer[$name]);
        return $type;
    }
    public function version() : int
    {
        return $this->version;
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\VarDocBuffer', 'Phpactor\\WorseReflection\\Core\\Inference\\VarDocBuffer', \false);
