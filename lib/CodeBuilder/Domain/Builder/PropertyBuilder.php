<?php

namespace Phpactor\CodeBuilder\Domain\Builder;

use Phpactor\CodeBuilder\Domain\Prototype\Type;
use Phpactor\CodeBuilder\Domain\Prototype\UpdatePolicy;
use Phpactor\CodeBuilder\Domain\Prototype\Visibility;
use Phpactor\CodeBuilder\Domain\Prototype\DefaultValue;
use Phpactor\CodeBuilder\Domain\Prototype\Property;
class PropertyBuilder extends \Phpactor\CodeBuilder\Domain\Builder\AbstractBuilder implements \Phpactor\CodeBuilder\Domain\Builder\NamedBuilder
{
    protected ?Visibility $visibility = null;
    protected ?Type $type = null;
    protected ?DefaultValue $defaultValue = null;
    private ?Type $docType = null;
    public function __construct(private \Phpactor\CodeBuilder\Domain\Builder\ClassLikeBuilder $parent, protected string $name)
    {
    }
    public static function childNames() : array
    {
        return [];
    }
    public function visibility(string $visibility) : \Phpactor\CodeBuilder\Domain\Builder\PropertyBuilder
    {
        $this->visibility = Visibility::fromString($visibility);
        return $this;
    }
    /**
     * @param mixed $originalType
     */
    public function type(string $type, $originalType = null) : \Phpactor\CodeBuilder\Domain\Builder\PropertyBuilder
    {
        $this->type = new Type($type, $originalType);
        return $this;
    }
    public function docType(string $type) : \Phpactor\CodeBuilder\Domain\Builder\PropertyBuilder
    {
        $this->docType = Type::fromString($type);
        return $this;
    }
    /**
     * @param mixed $value
     */
    public function defaultValue($value) : \Phpactor\CodeBuilder\Domain\Builder\PropertyBuilder
    {
        $this->defaultValue = DefaultValue::fromValue($value);
        return $this;
    }
    public function build() : Property
    {
        return new Property($this->name, $this->visibility, $this->defaultValue, $this->type, $this->docType, UpdatePolicy::fromModifiedState($this->isModified()));
    }
    public function end() : \Phpactor\CodeBuilder\Domain\Builder\ClassLikeBuilder
    {
        return $this->parent;
    }
    public function builderName() : string
    {
        return $this->name;
    }
}
