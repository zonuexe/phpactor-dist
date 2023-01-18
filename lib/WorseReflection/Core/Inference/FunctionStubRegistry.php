<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference;

final class FunctionStubRegistry
{
    /**
     * @param array<string,FunctionStub> $functionMap
     */
    public function __construct(private array $functionMap)
    {
    }
    public function get(string $name) : ?FunctionStub
    {
        if (!isset($this->functionMap[$name])) {
            return null;
        }
        return $this->functionMap[$name];
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\FunctionStubRegistry', 'Phpactor\\WorseReflection\\Core\\Inference\\FunctionStubRegistry', \false);
