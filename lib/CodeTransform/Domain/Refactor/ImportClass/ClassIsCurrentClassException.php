<?php

namespace Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\ImportClass;

use Phpactor202301\Phpactor\CodeTransform\Domain\Exception\TransformException;
class ClassIsCurrentClassException extends TransformException
{
    private string $name;
    public function __construct(NameImport $nameImport)
    {
        parent::__construct(\sprintf('%s "%s" is the current class', \ucfirst($nameImport->type()), $nameImport->name()->head()));
        $this->name = $nameImport->name()->head()->__toString();
    }
    public function name() : string
    {
        return $this->name;
    }
}
\class_alias('Phpactor202301\\Phpactor\\CodeTransform\\Domain\\Refactor\\ImportClass\\ClassIsCurrentClassException', 'Phpactor\\CodeTransform\\Domain\\Refactor\\ImportClass\\ClassIsCurrentClassException', \false);
