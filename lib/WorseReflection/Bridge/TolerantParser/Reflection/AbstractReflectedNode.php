<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflection;

use Phpactor202301\Phpactor\WorseReflection\Core\Position;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionScope as CoreReflectionScope;
use Phpactor202301\Phpactor\WorseReflection\Core\ServiceLocator;
abstract class AbstractReflectedNode
{
    public function position() : Position
    {
        return Position::fromFullStartStartAndEnd($this->node()->getFullStartPosition(), $this->node()->getStartPosition(), $this->node()->getEndPosition());
    }
    public function scope() : CoreReflectionScope
    {
        return new ReflectionScope($this->serviceLocator()->reflector(), $this->node());
    }
    protected abstract function node() : Node;
    protected abstract function serviceLocator() : ServiceLocator;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\AbstractReflectedNode', 'Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\AbstractReflectedNode', \false);
