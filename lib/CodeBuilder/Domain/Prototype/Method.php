<?php

namespace Phpactor\CodeBuilder\Domain\Prototype;

final class Method extends \Phpactor\CodeBuilder\Domain\Prototype\Prototype
{
    const IS_STATIC = 1;
    const IS_ABSTRACT = 2;
    private \Phpactor\CodeBuilder\Domain\Prototype\Visibility $visibility;
    private \Phpactor\CodeBuilder\Domain\Prototype\Parameters $parameters;
    private \Phpactor\CodeBuilder\Domain\Prototype\ReturnType $returnType;
    /*
     * @var Docblock
     */
    private $docblock;
    private bool $isStatic;
    private bool $isAbstract;
    private \Phpactor\CodeBuilder\Domain\Prototype\MethodBody $methodBody;
    public function __construct(private string $name, \Phpactor\CodeBuilder\Domain\Prototype\Visibility $visibility = null, \Phpactor\CodeBuilder\Domain\Prototype\Parameters $parameters = null, \Phpactor\CodeBuilder\Domain\Prototype\ReturnType $returnType = null, \Phpactor\CodeBuilder\Domain\Prototype\Docblock $docblock = null, int $modifierFlags = 0, \Phpactor\CodeBuilder\Domain\Prototype\MethodBody $methodBody = null, \Phpactor\CodeBuilder\Domain\Prototype\UpdatePolicy $updatePolicy = null)
    {
        parent::__construct($updatePolicy);
        $this->visibility = $visibility ?: \Phpactor\CodeBuilder\Domain\Prototype\Visibility::public();
        $this->parameters = $parameters ?: \Phpactor\CodeBuilder\Domain\Prototype\Parameters::empty();
        $this->returnType = $returnType ?: \Phpactor\CodeBuilder\Domain\Prototype\ReturnType::none();
        $this->docblock = $docblock ?: \Phpactor\CodeBuilder\Domain\Prototype\Docblock::none();
        $this->isStatic = (bool) ($modifierFlags & self::IS_STATIC);
        $this->isAbstract = (bool) ($modifierFlags & self::IS_ABSTRACT);
        $this->methodBody = $methodBody ?: \Phpactor\CodeBuilder\Domain\Prototype\MethodBody::empty();
    }
    public function name() : string
    {
        return $this->name;
    }
    public function visibility() : \Phpactor\CodeBuilder\Domain\Prototype\Visibility
    {
        return $this->visibility;
    }
    public function parameters() : \Phpactor\CodeBuilder\Domain\Prototype\Parameters
    {
        return $this->parameters;
    }
    public function returnType() : \Phpactor\CodeBuilder\Domain\Prototype\ReturnType
    {
        return $this->returnType;
    }
    public function docblock() : \Phpactor\CodeBuilder\Domain\Prototype\Docblock
    {
        return $this->docblock;
    }
    public function isStatic() : bool
    {
        return $this->isStatic;
    }
    public function isAbstract() : bool
    {
        return $this->isAbstract;
    }
    public function body() : \Phpactor\CodeBuilder\Domain\Prototype\MethodBody
    {
        return $this->methodBody;
    }
}
