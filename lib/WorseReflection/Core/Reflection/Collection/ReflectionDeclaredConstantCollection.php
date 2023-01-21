<?php

namespace Phpactor\WorseReflection\Core\Reflection\Collection;

use Phpactor202301\Microsoft\PhpParser\Node\Expression\CallExpression;
use Phpactor202301\Microsoft\PhpParser\Node\QualifiedName;
use Phpactor202301\Microsoft\PhpParser\Node\SourceFileNode;
use Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\ReflectionDeclaredConstant as PhpactorReflectionDeclaredConstant;
use Phpactor\WorseReflection\Core\Reflection\ReflectionDeclaredConstant;
use Phpactor\WorseReflection\Core\ServiceLocator;
use Phpactor\WorseReflection\Core\SourceCode;
use Phpactor\WorseReflection\Core\Util\NodeUtil;
/**
 * @extends AbstractReflectionCollection<ReflectionDeclaredConstant>
 */
class ReflectionDeclaredConstantCollection extends \Phpactor\WorseReflection\Core\Reflection\Collection\AbstractReflectionCollection
{
    /**
     * @param ReflectionDeclaredConstant[] $constants
     */
    public static function fromReflectionConstants(array $constants) : self
    {
        return new self($constants);
    }
    public static function fromNode(ServiceLocator $serviceLocator, SourceCode $sourceCode, SourceFileNode $node) : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionDeclaredConstantCollection
    {
        $items = [];
        foreach ($node->getDescendantNodes() as $descendentNode) {
            if (!$descendentNode instanceof CallExpression) {
                continue;
            }
            $callable = $descendentNode->callableExpression;
            /**
             * @phpstan-ignore-next-line TP lies
             */
            if (!$callable instanceof QualifiedName) {
                continue;
            }
            /** @phpstan-ignore-next-line */
            if ('define' !== NodeUtil::shortName($callable)) {
                continue;
            }
            $constant = new PhpactorReflectionDeclaredConstant($serviceLocator, $sourceCode, $descendentNode);
            $items[$constant->name()->__toString()] = $constant;
        }
        return new self($items);
    }
}
