<?php

namespace Phpactor\WorseReflection\Core\Inference;

use Closure;
use Phpactor\WorseReflection\Core\Type;
use Phpactor\WorseReflection\Core\Type\MissingType;
use Phpactor\WorseReflection\Core\Type\VoidType;
class Frame
{
    private \Phpactor\WorseReflection\Core\Inference\PropertyAssignments $properties;
    private \Phpactor\WorseReflection\Core\Inference\LocalAssignments $locals;
    private \Phpactor\WorseReflection\Core\Inference\Problems $problems;
    /**
     * @var Frame[]
     */
    private array $children = [];
    private ?Type $returnType = null;
    private int $version = 1;
    private \Phpactor\WorseReflection\Core\Inference\VarDocBuffer $varDocBuffer;
    public function __construct(private string $name, \Phpactor\WorseReflection\Core\Inference\LocalAssignments $locals = null, \Phpactor\WorseReflection\Core\Inference\PropertyAssignments $properties = null, \Phpactor\WorseReflection\Core\Inference\Problems $problems = null, private ?\Phpactor\WorseReflection\Core\Inference\Frame $parent = null)
    {
        $this->properties = $properties ?: \Phpactor\WorseReflection\Core\Inference\PropertyAssignments::create();
        $this->locals = $locals ?: \Phpactor\WorseReflection\Core\Inference\LocalAssignments::create();
        $this->problems = $problems ?: \Phpactor\WorseReflection\Core\Inference\Problems::create();
        $this->varDocBuffer = new \Phpactor\WorseReflection\Core\Inference\VarDocBuffer();
    }
    public function __toString() : string
    {
        return \implode("\n", \array_map(function (\Phpactor\WorseReflection\Core\Inference\Assignments $assignments, string $type) {
            return $type . "\n:" . $assignments->__toString();
        }, [$this->properties, $this->locals], ['properties', 'locals']));
    }
    public function new(string $name) : \Phpactor\WorseReflection\Core\Inference\Frame
    {
        $frame = new self($name, null, null, null, $this);
        $this->children[] = $frame;
        return $frame;
    }
    /**
     * @return Assignments<Variable>
     */
    public function locals() : \Phpactor\WorseReflection\Core\Inference\Assignments
    {
        return $this->locals;
    }
    public function properties() : \Phpactor\WorseReflection\Core\Inference\Assignments
    {
        return $this->properties;
    }
    public function problems() : \Phpactor\WorseReflection\Core\Inference\Problems
    {
        return $this->problems;
    }
    public function parent() : \Phpactor\WorseReflection\Core\Inference\Frame
    {
        return $this->parent;
    }
    public function reduce(Closure $closure, $initial = null)
    {
        $initial = $closure($this, $initial);
        foreach ($this->children as $childFrame) {
            $initial = $childFrame->reduce($closure, $initial);
        }
        return $initial;
    }
    public function root()
    {
        if (null === $this->parent) {
            return $this;
        }
        return $this->parent->root();
    }
    public function children() : array
    {
        return $this->children;
    }
    public function name() : string
    {
        return $this->name;
    }
    public function withReturnType(Type $type) : self
    {
        $this->returnType = $type;
        $this->version++;
        return $this;
    }
    public function applyTypeAssertions(\Phpactor\WorseReflection\Core\Inference\TypeAssertions $typeAssertions, int $contextOffset, ?int $createAtOffset = null) : void
    {
        foreach ([[$typeAssertions->properties(), $this->properties()], [$typeAssertions->variables(), $this->locals()]] as [$typeAssertions, $frameVariables]) {
            foreach ($typeAssertions as $typeAssertion) {
                $original = null;
                foreach ($frameVariables->byName($typeAssertion->name())->lessThanOrEqualTo($contextOffset) as $variable) {
                    $original = $variable;
                }
                $originalType = $original ? $original->type() : new MissingType();
                $variable = new \Phpactor\WorseReflection\Core\Inference\Variable($typeAssertion->name(), $createAtOffset ?: $typeAssertion->offset(), $typeAssertion->apply($originalType), $typeAssertion->classType());
                $type = $variable->type();
                $frameVariables->set($variable);
            }
        }
    }
    public function returnType() : Type
    {
        return $this->returnType ?: new VoidType();
    }
    /**
     * The version is incremented when the frame or one of it's components is
     * modified and can be used for cache busting.
     */
    public function version() : string
    {
        return \sprintf('%s-%s-%s-%s', $this->locals()->version(), $this->properties()->version(), $this->varDocBuffer()->version(), $this->version);
    }
    public function varDocBuffer() : \Phpactor\WorseReflection\Core\Inference\VarDocBuffer
    {
        return $this->varDocBuffer;
    }
}
