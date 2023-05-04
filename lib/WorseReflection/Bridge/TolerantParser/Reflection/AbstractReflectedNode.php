<?php

namespace Phpactor\WorseReflection\Bridge\TolerantParser\Reflection;

use Phpactor\TextDocument\ByteOffsetRange;
use PhpactorDist\Microsoft\PhpParser\Node;
use Phpactor\WorseReflection\Core\Reflection\ReflectionScope as CoreReflectionScope;
use Phpactor\WorseReflection\Core\ServiceLocator;
abstract class AbstractReflectedNode
{
    public function position() : ByteOffsetRange
    {
        return ByteOffsetRange::fromInts($this->node()->getStartPosition(), $this->node()->getEndPosition());
    }
    public function scope() : CoreReflectionScope
    {
        return new \Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\ReflectionScope($this->serviceLocator()->reflector(), $this->node());
    }
    protected abstract function node() : Node;
    protected abstract function serviceLocator() : ServiceLocator;
}
