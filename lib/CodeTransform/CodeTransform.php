<?php

namespace Phpactor202301\Phpactor\CodeTransform;

use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\CodeTransform\Domain\Transformers;
class CodeTransform
{
    private function __construct(private Transformers $transformers)
    {
    }
    public static function fromTransformers(Transformers $transformers) : CodeTransform
    {
        return new self($transformers);
    }
    public function transformers() : Transformers
    {
        return $this->transformers;
    }
    /**
     * @param mixed $code
     */
    public function transform($code, array $transformations) : SourceCode
    {
        $code = SourceCode::fromUnknown($code);
        $transformers = $this->transformers->in($transformations);
        return $transformers->applyTo($code);
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\CodeTransform', 'Phpactor\\CodeTransform\\CodeTransform', \false);
