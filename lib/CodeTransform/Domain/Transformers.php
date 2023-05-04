<?php

namespace Phpactor\CodeTransform\Domain;

use PhpactorDist\Amp\Promise;
use function PhpactorDist\Amp\call;
/**
 * @extends AbstractCollection<Transformer>
 */
final class Transformers extends \Phpactor\CodeTransform\Domain\AbstractCollection
{
    /**
     * @return Promise<SourceCode>
     */
    public function applyTo(\Phpactor\CodeTransform\Domain\SourceCode $code) : Promise
    {
        return call(function () use($code) {
            foreach ($this as $transformer) {
                \assert($transformer instanceof \Phpactor\CodeTransform\Domain\Transformer);
                $code = \Phpactor\CodeTransform\Domain\SourceCode::fromStringAndPath(((yield $transformer->transform($code)))->apply($code), $code->uri()->__toString());
            }
            return $code;
        });
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
