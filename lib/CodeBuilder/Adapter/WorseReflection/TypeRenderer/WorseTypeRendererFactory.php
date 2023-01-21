<?php

namespace Phpactor\CodeBuilder\Adapter\WorseReflection\TypeRenderer;

final class WorseTypeRendererFactory
{
    /**
     * @param array<string,WorseTypeRenderer> $versionToRendererMap
     */
    public function __construct(private array $versionToRendererMap)
    {
    }
    public function rendererFor(string $phpVersion) : \Phpactor\CodeBuilder\Adapter\WorseReflection\TypeRenderer\WorseTypeRenderer
    {
        foreach ($this->versionToRendererMap as $version => $renderer) {
            if (\str_starts_with($phpVersion, $version)) {
                return $renderer;
            }
        }
        return new \Phpactor\CodeBuilder\Adapter\WorseReflection\TypeRenderer\WorseTypeRenderer74();
    }
}
