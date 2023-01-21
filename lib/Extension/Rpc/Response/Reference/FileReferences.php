<?php

namespace Phpactor\Extension\Rpc\Response\Reference;

class FileReferences
{
    private array $references = [];
    private function __construct(private string $filePath, array $references)
    {
        foreach ($references as $reference) {
            $this->addReference($reference);
        }
    }
    public static function fromPathAndReferences($filePath, array $references)
    {
        return new self($filePath, $references);
    }
    public function toArray()
    {
        return ['file' => $this->filePath, 'references' => \array_map(function (\Phpactor\Extension\Rpc\Response\Reference\Reference $reference) {
            return $reference->toArray();
        }, $this->references)];
    }
    private function addReference(\Phpactor\Extension\Rpc\Response\Reference\Reference $reference) : void
    {
        $this->references[] = $reference;
    }
}
