<?php

namespace Phpactor\CodeTransform\Domain;

/**
 * @extends AbstractCollection<Transformer>
 */
final class Transformers extends \Phpactor\CodeTransform\Domain\AbstractCollection
{
    public function applyTo(\Phpactor\CodeTransform\Domain\SourceCode $code) : \Phpactor\CodeTransform\Domain\SourceCode
    {
        foreach ($this as $transformer) {
            \assert($transformer instanceof \Phpactor\CodeTransform\Domain\Transformer);
            $code = \Phpactor\CodeTransform\Domain\SourceCode::fromStringAndPath($transformer->transform($code)->apply($code), $code->uri()->__toString());
        }
        return $code;
    }
    public function in(array $transformerNames) : self
    {
        $transformers = [];
        foreach ($transformerNames as $transformerName) {
            $transformers[] = $this->get($transformerName);
        }
        return new self($transformers);
    }
    protected function type() : string
    {
        return \Phpactor\CodeTransform\Domain\Transformer::class;
    }
}
