<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflection\TypeResolver;

use Phpactor202301\Microsoft\PhpParser\Node\DelimitedList\QualifiedNameList;
use Phpactor202301\Microsoft\PhpParser\Token;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Phpactor\WorseReflection\Core\TypeFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\Util\NodeUtil;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
class DeclaredMemberTypeResolver
{
    public function __construct(private Reflector $reflector)
    {
    }
    /**
     * @param mixed $declaredTypes
     */
    public function resolveTypes(Node $tolerantNode, $declaredTypes = null, ?ClassName $className = null, bool $nullable = \false) : Type
    {
        if (!$declaredTypes instanceof QualifiedNameList) {
            return TypeFactory::undefined();
        }
        $type = NodeUtil::typeFromQualfiedNameLike($this->reflector, $tolerantNode, $declaredTypes, $className);
        if (!$nullable) {
            return $type;
        }
        return TypeFactory::nullable($type);
    }
    /**
     * @param null|Node|Token $tolerantType
     */
    public function resolve(Node $tolerantNode, $tolerantType = null, ?ClassName $className = null, bool $nullable = \false) : Type
    {
        $type = $this->doResolve($tolerantType, $tolerantNode, $className);
        if ($nullable) {
            return TypeFactory::nullable($type);
        }
        return $type;
    }
    /**
     * @param null|Node|Token $tolerantType
     */
    private function doResolve($tolerantType, ?Node $tolerantNode, ?ClassName $className = null) : Type
    {
        if (null === $tolerantType) {
            return TypeFactory::undefined();
        }
        return NodeUtil::typeFromQualfiedNameLike($this->reflector, $tolerantNode, $tolerantType, $className);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\TypeResolver\\DeclaredMemberTypeResolver', 'Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\TypeResolver\\DeclaredMemberTypeResolver', \false);
