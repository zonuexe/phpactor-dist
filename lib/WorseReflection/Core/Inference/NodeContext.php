<?php

namespace Phpactor\WorseReflection\Core\Inference;

use Phpactor\WorseReflection\Core\Type;
use Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor\WorseReflection\Core\Type\MissingType;
use Phpactor\WorseReflection\Core\Reflection\ReflectionScope;
class NodeContext
{
    private \Phpactor\WorseReflection\Core\Inference\TypeAssertions $typeAssertions;
    /**
     * @var string[]
     */
    private array $issues = [];
    protected function __construct(protected \Phpactor\WorseReflection\Core\Inference\Symbol $symbol, protected Type $type, protected ?Type $containerType = null, private ?ReflectionScope $scope = null)
    {
        $this->typeAssertions = new \Phpactor\WorseReflection\Core\Inference\TypeAssertions([]);
    }
    public static function for(\Phpactor\WorseReflection\Core\Inference\Symbol $symbol) : \Phpactor\WorseReflection\Core\Inference\NodeContext
    {
        return new self($symbol, TypeFactory::unknown());
    }
    public static function fromType(Type $type) : \Phpactor\WorseReflection\Core\Inference\NodeContext
    {
        return new self(\Phpactor\WorseReflection\Core\Inference\Symbol::unknown(), $type);
    }
    public static function none() : \Phpactor\WorseReflection\Core\Inference\NodeContext
    {
        return new self(\Phpactor\WorseReflection\Core\Inference\Symbol::unknown(), new MissingType());
    }
    public function withContainerType(Type $containerType) : \Phpactor\WorseReflection\Core\Inference\NodeContext
    {
        $new = clone $this;
        $new->containerType = $containerType;
        return $new;
    }
    public function withTypeAssertions(\Phpactor\WorseReflection\Core\Inference\TypeAssertions $typeAssertions) : \Phpactor\WorseReflection\Core\Inference\NodeContext
    {
        $new = clone $this;
        $new->typeAssertions = $typeAssertions;
        return $new;
    }
    public function withType(Type $type) : \Phpactor\WorseReflection\Core\Inference\NodeContext
    {
        $new = clone $this;
        $new->type = $type;
        return $new;
    }
    public function withTypeAssertion(\Phpactor\WorseReflection\Core\Inference\TypeAssertion $typeAssertion) : \Phpactor\WorseReflection\Core\Inference\NodeContext
    {
        $new = clone $this;
        $new->typeAssertions = $new->typeAssertions->add($typeAssertion);
        return $new;
    }
    public function withScope(ReflectionScope $scope) : \Phpactor\WorseReflection\Core\Inference\NodeContext
    {
        $new = clone $this;
        $new->scope = $scope;
        return $new;
    }
    public function withIssue(string $message) : \Phpactor\WorseReflection\Core\Inference\NodeContext
    {
        $new = clone $this;
        $new->issues[] = $message;
        return $new;
    }
    /**
     * @param Symbol::* $symbolType
     */
    public function withSymbolType($symbolType) : self
    {
        $new = clone $this;
        $new->symbol = $this->symbol->withSymbolType($symbolType);
        return $new;
    }
    public function withSymbolName(string $symbolName) : self
    {
        $new = clone $this;
        $new->symbol = $this->symbol->withSymbolName($symbolName);
        return $new;
    }
    public function type() : Type
    {
        return $this->type ?? new MissingType();
    }
    public function symbol() : \Phpactor\WorseReflection\Core\Inference\Symbol
    {
        return $this->symbol;
    }
    public function containerType() : Type
    {
        return $this->containerType ?: new MissingType();
    }
    /**
     * @return string[]
     */
    public function issues() : array
    {
        return $this->issues;
    }
    public function scope() : ReflectionScope
    {
        return $this->scope;
    }
    public function typeAssertions() : \Phpactor\WorseReflection\Core\Inference\TypeAssertions
    {
        return $this->typeAssertions;
    }
    public function negateTypeAssertions() : self
    {
        foreach ($this->typeAssertions as $typeAssertion) {
            $typeAssertion->negate();
        }
        return $this;
    }
}
