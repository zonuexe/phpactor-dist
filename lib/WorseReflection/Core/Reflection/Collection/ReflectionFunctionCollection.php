<?php

namespace Phpactor\WorseReflection\Core\Reflection\Collection;

use Phpactor\WorseReflection\Core\Reflection\ReflectionFunction as PhpactorReflectionFunction;
use Phpactor\WorseReflection\Core\ServiceLocator;
use Phpactor202301\Microsoft\PhpParser\Node\SourceFileNode;
use Phpactor\WorseReflection\Core\SourceCode;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\FunctionDeclaration;
use Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\ReflectionFunction;
/**
 * @extends AbstractReflectionCollection<PhpactorReflectionFunction>
 */
class ReflectionFunctionCollection extends \Phpactor\WorseReflection\Core\Reflection\Collection\AbstractReflectionCollection
{
    public static function fromNode(ServiceLocator $serviceLocator, SourceCode $sourceCode, SourceFileNode $node) : self
    {
        $items = [];
        foreach ($node->getDescendantNodes() as $descendentNode) {
            if (!$descendentNode instanceof FunctionDeclaration) {
                continue;
            }
            $items[(string) $descendentNode->getNamespacedName()] = new ReflectionFunction($sourceCode, $serviceLocator, $descendentNode);
        }
        return new self($items);
    }
}
