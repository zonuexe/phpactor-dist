<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\DocBlock;

use IteratorAggregate;
use ArrayIterator;
use Traversable;
/**
 * @implements IteratorAggregate<DocBlockParam>
 */
class DocBlockParams implements IteratorAggregate
{
    /**
     * @var DocBlockParam[]
     */
    private array $params = [];
    /**
     * @param DocBlockParam[] $params
     */
    public function __construct(array $params)
    {
        foreach ($params as $param) {
            $this->add($param);
        }
    }
    public function getIterator() : Traversable
    {
        return new ArrayIterator($this->params);
    }
    public function has(string $name) : bool
    {
        return isset($this->params[$name]);
    }
    private function add(DocBlockParam $param) : void
    {
        $this->params[$param->name()] = $param;
    }
}
/**
 * @implements IteratorAggregate<DocBlockParam>
 */
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\DocBlock\\DocBlockParams', 'Phpactor\\WorseReflection\\Core\\DocBlock\\DocBlockParams', \false);
