<?php

namespace Phpactor202301\Phpactor\Extension\PHPUnit\FrameWalker;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\CallExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\MemberAccessExpression;
use Phpactor202301\Microsoft\PhpParser\Node\Expression\ScopedPropertyAccessExpression;
use Phpactor202301\Microsoft\PhpParser\Node\QualifiedName;
use Phpactor202301\Microsoft\PhpParser\Token;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\FrameResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\FunctionArguments;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Variable;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Walker;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ClassStringType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ClassType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\StringLiteralType;
class AssertInstanceOfWalker implements Walker
{
    public function nodeFqns() : array
    {
        return [ScopedPropertyAccessExpression::class, MemberAccessExpression::class];
    }
    public function enter(FrameResolver $resolver, Frame $frame, Node $node) : Frame
    {
        return $frame;
    }
    public function exit(FrameResolver $resolver, Frame $frame, Node $node) : Frame
    {
        if (!$this->canWalk($node)) {
            return $frame;
        }
        $callExpression = $node->parent;
        if (!$callExpression instanceof CallExpression) {
            return $frame;
        }
        $args = FunctionArguments::fromList($resolver->resolver(), $frame, $callExpression->argumentExpressionList);
        if (\count($args) < 2) {
            return $frame;
        }
        $type = $args->at(0)->type();
        if ($type instanceof StringLiteralType) {
            $type = TypeFactory::reflectedClass($resolver->reflector(), $type->value());
        }
        if ($type instanceof ClassStringType) {
            $type = TypeFactory::reflectedClass($resolver->reflector(), $type->className()?->__toString());
        }
        if (!$type instanceof ClassType) {
            return $frame;
        }
        $var = $args->at(1);
        $frame->locals()->set(Variable::fromSymbolContext($var->withType($type)));
        return $frame;
    }
    private function canWalk(Node $node) : bool
    {
        if ($node instanceof ScopedPropertyAccessExpression) {
            $scopeResolutionQualifier = $node->scopeResolutionQualifier;
            if (!$scopeResolutionQualifier instanceof QualifiedName) {
                return \false;
            }
            $resolvedName = $scopeResolutionQualifier->getResolvedName();
            if ((string) $resolvedName !== 'PHPUnit\\Framework\\Assert') {
                return \false;
            }
            return \true;
        }
        if ($node instanceof MemberAccessExpression) {
            $memberName = $node->memberName;
            if (!$memberName instanceof Token) {
                return \false;
            }
            // we havn't got the facility to check if we are extending the TestCase
            // here, so just assume that any method named this way is belonging to
            // PHPUnit
            if ('assertInstanceOf' === $memberName->getText($node->getFileContents())) {
                return \true;
            }
        }
        return \false;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\PHPUnit\\FrameWalker\\AssertInstanceOfWalker', 'Phpactor\\Extension\\PHPUnit\\FrameWalker\\AssertInstanceOfWalker', \false);
