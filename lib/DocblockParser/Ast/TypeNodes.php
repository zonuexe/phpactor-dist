<?php

namespace Phpactor\DocblockParser\Ast;

use ArrayIterator;
use IteratorAggregate;
use RuntimeException;
use Traversable;
/**
 * @implements IteratorAggregate<TypeNode>
 */
class TypeNodes implements IteratorAggregate
{
    /**
     * @var TypeNode[]
     */
    private array $types;
    public function __construct(\Phpactor\DocblockParser\Ast\TypeNode ...$types)
    {
        $this->types = $types;
    }
    public function getIterator() : Traversable
    {
        return new ArrayIterator($this->types);
    }
    public function first() : \Phpactor\DocblockParser\Ast\TypeNode
    {
        foreach ($this->types as $type) {
            return $type;
        }
        throw new RuntimeException(\sprintf('List has no first element'));
    }
}
