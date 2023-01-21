<?php

namespace Phpactor\Indexer\Model;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use RuntimeException;
use Traversable;
/**
 * @implements IteratorAggregate<IndexInfo>
 */
class IndexInfos implements IteratorAggregate, Countable
{
    /**
     * @param IndexInfo[] $infos
     */
    public function __construct(private array $infos)
    {
    }
    public function getIterator() : Traversable
    {
        return new ArrayIterator($this->infos);
    }
    public function get(string $name) : \Phpactor\Indexer\Model\IndexInfo
    {
        foreach ($this->infos as $info) {
            if ($info->name() === $name) {
                return $info;
            }
        }
        throw new RuntimeException(\sprintf('Index "%s" not found. Available indicies are: %s', $name, \implode(', ', $this->names())));
    }
    public function count() : int
    {
        return \count($this->infos);
    }
    /**
     * @return string[]
     */
    public function names() : array
    {
        return \array_map(function (\Phpactor\Indexer\Model\IndexInfo $info) : string {
            return $info->name();
        }, $this->infos);
    }
    /**
     * @return int[]
     */
    public function offsets() : array
    {
        return \range(1, \count($this->infos) + 1);
    }
    public function getByOffset(int $int) : \Phpactor\Indexer\Model\IndexInfo
    {
        $offset = 1;
        foreach ($this->infos as $info) {
            if ($offset++ === $int) {
                return $info;
            }
        }
        throw new RuntimeException(\sprintf('Index at offset "%s" not found. Available offsets are: %s', $int, \implode(', ', $this->offsets())));
    }
    public function remove(\Phpactor\Indexer\Model\IndexInfo $target) : self
    {
        return new self(\array_filter($this->infos, fn(\Phpactor\Indexer\Model\IndexInfo $info) => $info->name() !== $target->name()));
    }
    public function totalSize() : int
    {
        return \array_reduce($this->infos, fn(int $size, \Phpactor\Indexer\Model\IndexInfo $current) => $size + $current->size(), 0);
    }
}
