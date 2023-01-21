<?php

namespace Phpactor\DocblockParser\Ast;

use ArrayIterator;
use Countable;
use IteratorAggregate;
/**
 * @implements IteratorAggregate<int,Token|Element>
 */
class ArrayKeyValueList extends \Phpactor\DocblockParser\Ast\Node implements IteratorAggregate, Countable
{
    protected const CHILD_NAMES = ['list'];
    /**
     * @param array<Token|ArrayKeyValueNode> $list
     */
    public function __construct(public array $list)
    {
    }
    /**
     * @return ArrayIterator<int, Token|ArrayKeyValueNode>
     */
    public function getIterator() : ArrayIterator
    {
        return new ArrayIterator($this->list);
    }
    public function count() : int
    {
        return \count($this->list);
    }
    /**
     * @return ArrayKeyValueNode[]
     */
    public function arrayKeyValues() : array
    {
        return \array_filter($this->list, function (\Phpactor\DocblockParser\Ast\Element $element) {
            return $element instanceof \Phpactor\DocblockParser\Ast\ArrayKeyValueNode;
        });
    }
}
