<?php

namespace Phpactor202301\Phpactor\MapResolver;

class Definition
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var mixed
     */
    private $defaultValue;
    /**
     * @var bool
     */
    private $required;
    /**
     * @var array<string>
     */
    private $types;
    /**
     * @var array<mixed>
     */
    private array $enum = [];
    /**
     * @var string|null
     */
    private $description;
    /**
     * @param mixed $defaultValue
     * @param array<string> $types
     * @param array<mixed> $enum
     */
    public function __construct(string $name, $defaultValue, bool $required, ?string $description, array $types, array $enum)
    {
        $this->name = $name;
        $this->defaultValue = $defaultValue;
        $this->required = $required;
        $this->types = $types;
        $this->description = $description;
        $this->enum = $enum;
    }
    /**
     * @return array<string>
     */
    public function types() : array
    {
        return $this->types;
    }
    public function required() : bool
    {
        return $this->required;
    }
    /**
     * @return mixed
     */
    public function defaultValue()
    {
        return $this->defaultValue;
    }
    /**
     * @return array<mixed>
     */
    public function enum() : array
    {
        return $this->enum;
    }
    public function name() : string
    {
        return $this->name;
    }
    public function description() : ?string
    {
        return $this->description;
    }
}
\class_alias('Phpactor202301\\Phpactor\\MapResolver\\Definition', 'Phpactor\\MapResolver\\Definition', \false);
