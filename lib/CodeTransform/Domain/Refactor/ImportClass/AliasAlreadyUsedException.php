<?php

namespace Phpactor\CodeTransform\Domain\Refactor\ImportClass;

class AliasAlreadyUsedException extends \Phpactor\CodeTransform\Domain\Refactor\ImportClass\NameAlreadyUsedException
{
    private string $name;
    public function __construct(\Phpactor\CodeTransform\Domain\Refactor\ImportClass\NameImport $nameImport)
    {
        parent::__construct(\sprintf('%s alias "%s" is already used', \ucfirst($nameImport->type()), $nameImport->alias()));
        $this->name = $nameImport->name()->head()->__toString();
    }
    public function name() : string
    {
        return $this->name;
    }
}
