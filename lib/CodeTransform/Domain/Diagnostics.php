<?php

namespace Phpactor202301\Phpactor\CodeTransform\Domain;

/**
 * @extends AbstractCollection<Diagnostic>
 */
class Diagnostics extends AbstractCollection
{
    public static function none() : self
    {
        return new self([]);
    }
    protected function type() : string
    {
        return Diagnostic::class;
    }
}
/**
 * @extends AbstractCollection<Diagnostic>
 */
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Domain\\Diagnostics', 'Phpactor\\CodeTransform\\Domain\\Diagnostics', \false);
