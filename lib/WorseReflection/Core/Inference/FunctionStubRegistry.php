<?php

namespace Phpactor\WorseReflection\Core\Inference;

final class FunctionStubRegistry
{
    /**
     * @param array<string,FunctionStub> $functionMap
     */
    public function __construct(private array $functionMap)
    {
    }
    public function get(string $name) : ?\Phpactor\WorseReflection\Core\Inference\FunctionStub
    {
        if (!isset($this->functionMap[$name])) {
            return null;
        }
        return $this->functionMap[$name];
    }
}
