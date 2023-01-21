<?php

namespace Phpactor\MapResolver;

use ArrayIterator;
use Iterator;
use IteratorAggregate;
use RuntimeException;
/**
 * @implements IteratorAggregate<Definition>
 */
class Definitions implements IteratorAggregate
{
    /**
     * @var array<Definition>
     */
    private $definitions = [];
    /**
     * @param array<Definition> $definitions
     */
    public function __construct(array $definitions)
    {
        foreach ($definitions as $definition) {
            $this->add($definition);
        }
    }
    /**
     * @return Iterator<Definition>
     */
    public function getIterator() : Iterator
    {
        return new ArrayIterator($this->definitions);
    }
    public function get(string $name) : \Phpactor\MapResolver\Definition
    {
        if (!isset($this->definitions[$name])) {
            throw new RuntimeException(\sprintf('Definition "%s" does not exist', $name));
        }
        return $this->definitions[$name];
    }
    private function add(\Phpactor\MapResolver\Definition $definition) : void
    {
        $this->definitions[$definition->name()] = $definition;
    }
}
