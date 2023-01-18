<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Reflection;

use Phpactor202301\Microsoft\PhpParser\Node\QualifiedName;
use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionScope as CoreReflectionScope;
use Phpactor202301\Microsoft\PhpParser\Node;
use Phpactor202301\Phpactor\WorseReflection\Core\NameImports;
use Phpactor202301\Phpactor\WorseReflection\Core\Name;
use Phpactor202301\Microsoft\PhpParser\ResolvedName;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike;
use Phpactor202301\Phpactor\WorseReflection\Core\Inference\NodeToTypeConverter;
use Phpactor202301\Phpactor\WorseReflection\Bridge\PsrLog\ArrayLogger;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ClassType;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\UnionType;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
class ReflectionScope implements CoreReflectionScope
{
    public function __construct(private Reflector $reflector, private Node $node)
    {
    }
    /**
     * @return NameImports<Name>
     */
    public function nameImports() : NameImports
    {
        [$nameImports] = $this->node->getImportTablesForCurrentScope();
        return NameImports::fromNames(\array_map(function (ResolvedName $name) {
            return Name::fromParts($name->getNameParts());
        }, $nameImports));
    }
    public function namespace() : Name
    {
        $namespaceDefinition = $this->node->getNamespaceDefinition();
        if (null === $namespaceDefinition) {
            return Name::fromString('');
        }
        if (!$namespaceDefinition->name instanceof QualifiedName) {
            return Name::fromString('');
        }
        return Name::fromString($namespaceDefinition->name->getText());
    }
    public function resolveFullyQualifiedName($type, ReflectionClassLike $class = null) : Type
    {
        $resolver = new NodeToTypeConverter($this->reflector, new ArrayLogger());
        return $resolver->resolve($this->node, $type, $class ? $class->name() : null);
    }
    public function resolveLocalName(Name $name) : Name
    {
        return $this->nameImports()->resolveLocalName($name);
    }
    /**
     * TODO: This is not complete and doesn't work with complex types.
     *       see: https://github.com/phpactor/phpactor/issues/1453
     */
    public function resolveLocalType(Type $type) : Type
    {
        $union = UnionType::toUnion($type);
        foreach ($union->types as $type) {
            if ($type instanceof ClassType) {
                $type->name = ClassName::fromString($this->nameImports()->resolveLocalName($type->name())->__toString());
            }
        }
        return $union->reduce();
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\ReflectionScope', 'Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Reflection\\ReflectionScope', \false);
