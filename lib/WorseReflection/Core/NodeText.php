<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core;

final class NodeText
{
    private function __construct(private $nodeText)
    {
    }
    public function __toString()
    {
        return $this->nodeText;
    }
    public static function fromString(string $nodeText) : NodeText
    {
        return new self($nodeText);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\NodeText', 'Phpactor\\WorseReflection\\Core\\NodeText', \false);
