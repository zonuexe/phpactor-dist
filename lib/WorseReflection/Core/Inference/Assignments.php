<?php

namespace Phpactor\WorseReflection\Core\Inference;

use Countable;
use IteratorAggregate;
use RuntimeException;
use ArrayIterator;
/**
 * @implements IteratorAggregate<array-key,Variable>
 */
abstract class Assignments implements Countable, IteratorAggregate
{
    private int $version = 1;
    /**
     * @var array<string, Variable>-
     */
    private array $variables = [];
    /**
     * @param array<string|int,Variable> $variables
     */
    public final function __construct(array $variables)
    {
        foreach ($variables as $variable) {
            $this->variables[$variable->key()] = $variable;
        }
        $this->sort();
    }
    public function __toString() : string
    {
        return \implode("\n", \array_map(function (\Phpactor\WorseReflection\Core\Inference\Variable $variable) {
            return \sprintf('%s:%s: %s', $variable->name(), $variable->offset(), $variable->type()->__toString());
        }, \array_values($this->variables)));
    }
    public function set(\Phpactor\WorseReflection\Core\Inference\Variable $variable) : void
    {
        $this->version++;
        $this->variables[$variable->key()] = $variable;
        $this->sort();
    }
    public function add(\Phpactor\WorseReflection\Core\Inference\Variable $variable, int $offset) : void
    {
        $this->version++;
        $original = $this->byName($variable->name())->lessThanOrEqualTo($offset)->lastOrNull();
        if ($original === null) {
            $this->set($variable);
            return;
        }
        $this->set($variable->withOffset($variable->offset())->withType($original->type()->addType($variable->type())->clean()));
    }
    public function byName(string $name) : \Phpactor\WorseReflection\Core\Inference\Assignments
    {
        $name = \ltrim($name, '$');
        return new static(\array_filter($this->variables, function (\Phpactor\WorseReflection\Core\Inference\Variable $v) use($name) {
            return $v->name() === $name;
        }));
    }
    public function lessThanOrEqualTo(int $offset) : \Phpactor\WorseReflection\Core\Inference\Assignments
    {
        return new static(\array_filter($this->variables, function (\Phpactor\WorseReflection\Core\Inference\Variable $v) use($offset) {
            return $v->offset() <= $offset;
        }));
    }
    public function lessThan(int $offset) : \Phpactor\WorseReflection\Core\Inference\Assignments
    {
        return new static(\array_filter($this->variables, function (\Phpactor\WorseReflection\Core\Inference\Variable $v) use($offset) {
            return $v->offset() < $offset;
        }));
    }
    public function greaterThan(int $offset) : \Phpactor\WorseReflection\Core\Inference\Assignments
    {
        return new static(\array_filter($this->variables, function (\Phpactor\WorseReflection\Core\Inference\Variable $v) use($offset) {
            return $v->offset() > $offset;
        }));
    }
    public function greaterThanOrEqualTo(int $offset) : \Phpactor\WorseReflection\Core\Inference\Assignments
    {
        return new static(\array_filter($this->variables, function (\Phpactor\WorseReflection\Core\Inference\Variable $v) use($offset) {
            return $v->offset() >= $offset;
        }));
    }
    public function first() : \Phpactor\WorseReflection\Core\Inference\Variable
    {
        $first = \reset($this->variables);
        if (!$first) {
            throw new RuntimeException('Variable collection is empty');
        }
        return $first;
    }
    public function atIndex(int $index) : \Phpactor\WorseReflection\Core\Inference\Variable
    {
        $variables = \array_values($this->variables);
        if (!isset($variables[$index])) {
            throw new RuntimeException(\sprintf('No variable at index "%s"', $index));
        }
        return $variables[$index];
    }
    public function last() : \Phpactor\WorseReflection\Core\Inference\Variable
    {
        $last = \end($this->variables);
        if (!$last) {
            throw new RuntimeException('Cannot get last, variable collection is empty');
        }
        return $last;
    }
    public function count() : int
    {
        return \count($this->variables);
    }
    /**
     * @return ArrayIterator<array-key,Variable>
     */
    public function getIterator() : ArrayIterator
    {
        return new ArrayIterator(\array_values($this->variables));
    }
    public function merge(\Phpactor\WorseReflection\Core\Inference\Assignments $variables) : \Phpactor\WorseReflection\Core\Inference\Assignments
    {
        foreach ($variables->variables as $offset => $variable) {
            $this->variables[$offset] = $variable;
        }
        $this->sort();
        return $this;
    }
    public function replace(\Phpactor\WorseReflection\Core\Inference\Variable $existing, \Phpactor\WorseReflection\Core\Inference\Variable $replacement) : void
    {
        foreach ($this->variables as $offset => $variable) {
            if ($variable !== $existing) {
                continue;
            }
            $this->version++;
            $this->variables[$offset] = $replacement;
        }
    }
    public function equalTo(int $offset) : \Phpactor\WorseReflection\Core\Inference\Assignments
    {
        return new static(\array_filter($this->variables, function (\Phpactor\WorseReflection\Core\Inference\Variable $v) use($offset) {
            return $v->offset() === $offset;
        }));
    }
    public function not(int $offset) : \Phpactor\WorseReflection\Core\Inference\Assignments
    {
        return new static(\array_filter($this->variables, function (\Phpactor\WorseReflection\Core\Inference\Variable $v) use($offset) {
            return $v->offset() !== $offset;
        }));
    }
    public function assignmentsOnly() : \Phpactor\WorseReflection\Core\Inference\Assignments
    {
        return new static(\array_filter($this->variables, function (\Phpactor\WorseReflection\Core\Inference\Variable $v) {
            return $v->wasAssigned();
        }));
    }
    public function lastOrNull() : ?\Phpactor\WorseReflection\Core\Inference\Variable
    {
        $last = \end($this->variables);
        if (!$last) {
            return null;
        }
        return $last;
    }
    public function version() : int
    {
        return $this->version;
    }
    public function mostRecent() : self
    {
        $mostRecent = [];
        foreach ($this->variables as $variable) {
            $mostRecent[$variable->name()] = $variable;
        }
        return new static($mostRecent);
    }
    private function sort() : void
    {
        \uasort($this->variables, function (\Phpactor\WorseReflection\Core\Inference\Variable $one, \Phpactor\WorseReflection\Core\Inference\Variable $two) {
            return $one->offset() <=> $two->offset();
        });
    }
}
