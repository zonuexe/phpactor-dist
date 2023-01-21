<?php

namespace Phpactor\WorseReflection\Core\Inference;

use ArrayIterator;
use Closure;
use IteratorAggregate;
use Phpactor\WorseReflection\Core\Type;
use Phpactor\WorseReflection\Core\Type\UnionType;
use RuntimeException;
use Traversable;
/**
 * @implements IteratorAggregate<array-key,TypeAssertion>
 */
final class TypeAssertions implements IteratorAggregate
{
    /**
     * @var TypeAssertion[]
     */
    private array $typeAssertions = [];
    /**
     * @param TypeAssertion[] $typeAssertions
     */
    public function __construct(array $typeAssertions)
    {
        foreach ($typeAssertions as $assertion) {
            $key = $this->key($assertion);
            $this->typeAssertions[$key] = $assertion;
        }
    }
    public function __toString() : string
    {
        return \implode("\n", \array_map(function (\Phpactor\WorseReflection\Core\Inference\TypeAssertion $typeAssertion) {
            return $typeAssertion->__toString();
        }, $this->typeAssertions));
    }
    public function getIterator() : Traversable
    {
        return new ArrayIterator($this->typeAssertions);
    }
    public function add(\Phpactor\WorseReflection\Core\Inference\TypeAssertion $typeAssertion) : self
    {
        $assertions = $this->typeAssertions;
        $assertions[] = $typeAssertion;
        return new self($assertions);
    }
    public function variables() : self
    {
        return new self(\array_filter($this->typeAssertions, function (\Phpactor\WorseReflection\Core\Inference\TypeAssertion $typeAssertion) {
            return $typeAssertion->variableType() === \Phpactor\WorseReflection\Core\Inference\TypeAssertion::VARIABLE_TYPE_VARIABLE;
        }));
    }
    public function properties() : self
    {
        return new self(\array_filter($this->typeAssertions, function (\Phpactor\WorseReflection\Core\Inference\TypeAssertion $typeAssertion) {
            return $typeAssertion->variableType() === \Phpactor\WorseReflection\Core\Inference\TypeAssertion::VARIABLE_TYPE_PROPERTY;
        }));
    }
    public function negate() : self
    {
        return $this->map(function (\Phpactor\WorseReflection\Core\Inference\TypeAssertion $assertion) {
            $assertion->negate();
            return $assertion;
        });
    }
    public function map(Closure $closure) : self
    {
        return new self(\array_map($closure, $this->typeAssertions));
    }
    public function merge(\Phpactor\WorseReflection\Core\Inference\TypeAssertions $typeAssertions) : self
    {
        $assertions = $this->typeAssertions;
        foreach ($typeAssertions as $key => $assertion) {
            $assertions[$key] = $assertion;
        }
        return new self($assertions);
    }
    /**
     * Combine incoming type assertions with logical OR (union)
     *
     *   is_string($foobar)    => string
     *   ||
     *   is_bool($foobar)      => string|bool
     */
    public function or(\Phpactor\WorseReflection\Core\Inference\TypeAssertions $typeAssertions) : self
    {
        return $this->aggregate($typeAssertions, function (Type $type, \Phpactor\WorseReflection\Core\Inference\TypeAssertion $left, \Phpactor\WorseReflection\Core\Inference\TypeAssertion $right) {
            return UnionType::fromTypes($left->apply($type), $right->apply($type));
        }, function (Type $type, \Phpactor\WorseReflection\Core\Inference\TypeAssertion $left, \Phpactor\WorseReflection\Core\Inference\TypeAssertion $right) {
            return UnionType::fromTypes($left->negate()->apply($type), $right->negate()->apply($type));
        });
    }
    /**
     * Combine incoming type assertions with logical AND (intersection)
     *
     *   $foobar instanceof A  => A
     *   &&
     *   $foobar instanceof B  => A&B
     */
    public function and(\Phpactor\WorseReflection\Core\Inference\TypeAssertions $typeAssertions) : self
    {
        return $this->aggregate($typeAssertions, function (Type $type, \Phpactor\WorseReflection\Core\Inference\TypeAssertion $left, \Phpactor\WorseReflection\Core\Inference\TypeAssertion $right) {
            return $right->apply($left->apply($type));
        }, function (Type $type, \Phpactor\WorseReflection\Core\Inference\TypeAssertion $left, \Phpactor\WorseReflection\Core\Inference\TypeAssertion $right) {
            return UnionType::fromTypes($left->negate()->apply($type), $right->negate()->apply($type));
        });
    }
    public function firstForName(string $name) : \Phpactor\WorseReflection\Core\Inference\TypeAssertion
    {
        foreach ($this->typeAssertions as $assertion) {
            if ($assertion->name() === $name) {
                return $assertion;
            }
        }
        throw new RuntimeException(\sprintf('Type assertion collection has no assertion for name "%s"', $name));
    }
    private function aggregate(\Phpactor\WorseReflection\Core\Inference\TypeAssertions $typeAssertions, Closure $true, Closure $false) : self
    {
        $resolved = [];
        foreach ($this->typeAssertions as $typeAssertion) {
            $resolved[$typeAssertion->name()] = $typeAssertion;
        }
        foreach ($typeAssertions as $typeAssertion) {
            if (!isset($resolved[$typeAssertion->name()])) {
                $resolved[$typeAssertion->name()] = $typeAssertion;
                continue;
            }
            $left = $resolved[$typeAssertion->name()];
            $right = $typeAssertion;
            $resolved[$typeAssertion->name()] = \Phpactor\WorseReflection\Core\Inference\TypeAssertion::variable($typeAssertion->name(), $typeAssertion->offset(), fn(Type $type) => $true($type, $left, $right), fn(Type $type) => $false($type, $left, $right));
        }
        return new self($resolved);
    }
    private function key(\Phpactor\WorseReflection\Core\Inference\TypeAssertion $assertion) : string
    {
        $key = $assertion->variableType() . $assertion->name() . $assertion->offset();
        return $key;
    }
}
