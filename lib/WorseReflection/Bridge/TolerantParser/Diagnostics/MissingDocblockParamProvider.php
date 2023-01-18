<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Diagnostics;

use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Microsoft\PhpParser\Node\MethodDeclaration;
use Phpactor202301\Phpactor\TextDocument\ByteOffsetRange;
use Phpactor202301\Phpactor\WorseReflection\Core\DiagnosticProvider;
use Phpactor202301\Phpactor\WorseReflection\Core\DiagnosticSeverity;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\NotFound;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\Frame;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeContextResolver;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ArrayType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ClosureType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\MissingType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\MixedType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ReflectedClassType;
use Phpactor202301\Phpactor\WorseReflection\Core\Util\NodeUtil;
class MissingDocblockParamProvider implements DiagnosticProvider
{
    public function exit(NodeContextResolver $resolver, Frame $frame, Node $node) : iterable
    {
        if (!$node instanceof MethodDeclaration) {
            return;
        }
        $declaration = NodeUtil::nodeContainerClassLikeDeclaration($node);
        if (null === $declaration) {
            return;
        }
        try {
            $class = $resolver->reflector()->reflectClassLike($declaration->getNamespacedName()->__toString());
            $methodName = $node->name->getText($node->getFileContents());
            if (!\is_string($methodName)) {
                return;
            }
            $method = $class->methods()->get($methodName);
        } catch (NotFound) {
            return;
        }
        // do not try it for overriden methods
        if ($method->original()->declaringClass()->name() != $class->name()) {
            return;
        }
        $docblock = $method->docblock();
        $docblockParams = $docblock->params();
        $missingParams = [];
        foreach ($method->parameters() as $parameter) {
            $type = $parameter->type();
            $type = $this->upcastType($type, $resolver);
            $parameterType = $parameter->type();
            if ($docblockParams->has($parameter->name())) {
                continue;
            }
            if ($parameter->isVariadic()) {
                if ($type instanceof ArrayType) {
                    $type = $type->iterableValueType();
                }
                if ($parameterType instanceof ArrayType) {
                    $parameterType = $parameterType->iterableValueType();
                }
            }
            if ($type instanceof ArrayType) {
                $type = new ArrayType(TypeFactory::int(), TypeFactory::mixed());
            }
            // replace <undefined> with "mixed"
            $type = $type->map(fn(Type $type) => $type instanceof MissingType ? new MixedType() : $type);
            if ($type->__toString() === $parameterType->__toString()) {
                continue;
            }
            (yield new MissingDocblockParamDiagnostic(ByteOffsetRange::fromInts($parameter->position()->start(), $parameter->position()->end()), \sprintf('Method "%s" is missing @param $%s', $methodName, $parameter->name()), DiagnosticSeverity::WARNING(), $class->name()->__toString(), $methodName, $parameter->name(), $type));
        }
    }
    public function enter(NodeContextResolver $resolver, Frame $frame, Node $node) : iterable
    {
        return [];
    }
    private function upcastType(Type $type, NodeContextResolver $resolver) : Type
    {
        if (!$type instanceof ReflectedClassType) {
            return $type;
        }
        if ($type->name()->__toString() === 'Closure') {
            return new ClosureType($resolver->reflector(), [], TypeFactory::void());
        }
        return $type->upcastToGeneric();
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Diagnostics\\MissingDocblockParamProvider', 'Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Diagnostics\\MissingDocblockParamProvider', \false);
