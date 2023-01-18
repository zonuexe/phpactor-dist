<?php

namespace Phpactor202301\Phpactor\CodeTransform\Domain;

/**
 * @extends AbstractCollection<Generator>
 */
final class Generators extends AbstractCollection
{
    protected function type() : string
    {
        return Generator::class;
    }
}
/**
 * @extends AbstractCollection<Generator>
 */
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Domain\\Generators', 'Phpactor\\CodeTransform\\Domain\\Generators', \false);
