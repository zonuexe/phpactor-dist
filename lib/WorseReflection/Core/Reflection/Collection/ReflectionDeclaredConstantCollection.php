<?php

namespace Phpactor\WorseReflection\Core\Reflection\Collection;

use PhpactorDist\Microsoft\PhpParser\Node\Expression\CallExpression;
use PhpactorDist\Microsoft\PhpParser\Node\QualifiedName;
use PhpactorDist\Microsoft\PhpParser\Node\SourceFileNode;
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
            if (!$callable instanceof QualifiedName) {
                continue;
            }
            if ('define' !== NodeUtil::shortName($callable)) {
                continue;
            }
            $constant = new PhpactorReflectionDeclaredConstant($serviceLocator, $sourceCode, $descendentNode);
            $items[$constant->name()->__toString()] = $constant;
        }
        return new self($items);
    }
}
