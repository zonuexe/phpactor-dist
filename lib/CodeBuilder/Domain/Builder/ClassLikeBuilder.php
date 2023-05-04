<?php

namespace Phpactor\CodeBuilder\Domain\Builder;

use Phpactor\CodeBuilder\Domain\Builder\Exception\InvalidBuilderException;
use Phpactor\CodeBuilder\Domain\Prototype\Docblock;
abstract class ClassLikeBuilder extends \Phpactor\CodeBuilder\Domain\Builder\AbstractBuilder implements \Phpactor\CodeBuilder\Domain\Builder\Builder
{
    /**
     * @var MethodBuilder[]
     */
    protected array $methods = [];
    protected ?Docblock $docblock = null;
    public function __construct(private \Phpactor\CodeBuilder\Domain\Builder\SourceCodeBuilder $parent, protected string $name)
    {
        $this->docblock = null;
    }
    public static function childNames() : array
    {
        return ['methods'];
    }
    public function add(\Phpactor\CodeBuilder\Domain\Builder\Builder $builder) : void
    {
        if ($builder instanceof \Phpactor\CodeBuilder\Domain\Builder\MethodBuilder) {
            $this->methods[$builder->builderName()] = $builder;
            return;
        }
        throw new InvalidBuilderException($this, $builder);
    }
    public function method(string $name) : \Phpactor\CodeBuilder\Domain\Builder\MethodBuilder
    {
        if (isset($this->methods[$name])) {
            return $this->methods[$name];
        }
        $this->methods[$name] = $builder = new \Phpactor\CodeBuilder\Domain\Builder\MethodBuilder($this, $name);
        return $builder;
    }
    public function end() : \Phpactor\CodeBuilder\Domain\Builder\SourceCodeBuilder
    {
        return $this->parent;
    }
    public function docblock(string $docblock) : \Phpactor\CodeBuilder\Domain\Builder\ClassLikeBuilder
    {
        $this->docblock = Docblock::fromString($docblock);
        return $this;
    }
    public function getDocblock() : ?Docblock
    {
        return $this->docblock;
    }
}
