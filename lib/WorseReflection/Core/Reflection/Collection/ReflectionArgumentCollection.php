<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection;

use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionArgument as PhpactorReflectionArgument;
use Phpactor202301\Phpactor\WorseReflection\Core\ServiceLocator;
use Phpactor202301\Microsoft\PhpParser\Node\DelimitedList\ArgumentExpressionList;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\ReflectionArgument;
/**
 * @extends AbstractReflectionCollection<PhpactorReflectionArgument>
 */
class ReflectionArgumentCollection extends AbstractReflectionCollection
{
    public static function fromArgumentListAndFrame(ServiceLocator $locator, ArgumentExpressionList $list, Frame $frame) : self
    {
        $arguments = [];
        foreach ($list->getElements() as $element) {
            $arguments[] = new ReflectionArgument($locator, $frame, $element);
        }
        return new self($arguments);
    }
    public function notPromoted() : self
    {
        return $this;
    }
    public function promoted() : self
    {
        return new self([]);
    }
    /**
     * @return array<string,PhpactorReflectionArgument>
     */
    public function named() : array
    {
        $arguments = [];
        $counters = [];
        foreach ($this as $argument) {
            $name = $argument->guessName();
            if (isset($arguments[$name])) {
                if (!isset($counters[$name])) {
                    $counters[$name] = 1;
                }
                $counters[$name]++;
                $name = $argument->guessName() . $counters[$name];
            }
            $arguments[$name] = $argument;
        }
        return $arguments;
    }
}
/**
 * @extends AbstractReflectionCollection<PhpactorReflectionArgument>
 */
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\Collection\\ReflectionArgumentCollection', 'Phpactor\\WorseReflection\\Core\\Reflection\\Collection\\ReflectionArgumentCollection', \false);
