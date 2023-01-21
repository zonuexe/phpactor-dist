<?php

namespace Phpactor\CodeBuilder\Domain\Prototype;

class SourceCode extends \Phpactor\CodeBuilder\Domain\Prototype\Prototype
{
    private \Phpactor\CodeBuilder\Domain\Prototype\QualifiedName $namespace;
    private \Phpactor\CodeBuilder\Domain\Prototype\UseStatements $useStatements;
    private \Phpactor\CodeBuilder\Domain\Prototype\Classes $classes;
    private \Phpactor\CodeBuilder\Domain\Prototype\Interfaces $interfaces;
    private \Phpactor\CodeBuilder\Domain\Prototype\Traits $traits;
    public function __construct(\Phpactor\CodeBuilder\Domain\Prototype\QualifiedName $namespace = null, \Phpactor\CodeBuilder\Domain\Prototype\UseStatements $useStatements = null, \Phpactor\CodeBuilder\Domain\Prototype\Classes $classes = null, \Phpactor\CodeBuilder\Domain\Prototype\Interfaces $interfaces = null, \Phpactor\CodeBuilder\Domain\Prototype\Traits $traits = null, \Phpactor\CodeBuilder\Domain\Prototype\UpdatePolicy $updatePolicy = null)
    {
        parent::__construct($updatePolicy);
        $this->namespace = $namespace ?: \Phpactor\CodeBuilder\Domain\Prototype\NamespaceName::fromString('');
        $this->useStatements = $useStatements ?: \Phpactor\CodeBuilder\Domain\Prototype\UseStatements::empty();
        $this->classes = $classes ?: \Phpactor\CodeBuilder\Domain\Prototype\Classes::empty();
        $this->interfaces = $interfaces ?: \Phpactor\CodeBuilder\Domain\Prototype\Interfaces::empty();
        $this->traits = $traits ?: \Phpactor\CodeBuilder\Domain\Prototype\Traits::empty();
    }
    public function namespace() : \Phpactor\CodeBuilder\Domain\Prototype\QualifiedName
    {
        return $this->namespace;
    }
    public function useStatements() : \Phpactor\CodeBuilder\Domain\Prototype\UseStatements
    {
        return $this->useStatements;
    }
    public function classes() : \Phpactor\CodeBuilder\Domain\Prototype\Classes
    {
        return $this->classes;
    }
    public function interfaces() : \Phpactor\CodeBuilder\Domain\Prototype\Interfaces
    {
        return $this->interfaces;
    }
    public function traits() : \Phpactor\CodeBuilder\Domain\Prototype\Traits
    {
        return $this->traits;
    }
}
