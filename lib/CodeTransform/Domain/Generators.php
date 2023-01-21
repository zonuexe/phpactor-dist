<?php

namespace Phpactor\CodeTransform\Domain;

/**
 * @extends AbstractCollection<Generator>
 */
final class Generators extends \Phpactor\CodeTransform\Domain\AbstractCollection
{
    protected function type() : string
    {
        return \Phpactor\CodeTransform\Domain\Generator::class;
    }
}
