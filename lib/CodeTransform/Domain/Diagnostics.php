<?php

namespace Phpactor\CodeTransform\Domain;

/**
 * @extends AbstractCollection<Diagnostic>
 */
class Diagnostics extends \Phpactor\CodeTransform\Domain\AbstractCollection
{
    public static function none() : self
    {
        return new self([]);
    }
    protected function type() : string
    {
        return \Phpactor\CodeTransform\Domain\Diagnostic::class;
    }
}
