<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection;

use Phpactor202301\Microsoft\PhpParser\Node\ClassInterfaceClause;
use Phpactor202301\Microsoft\PhpParser\Node\InterfaceBaseClause;
use Phpactor202301\Phpactor\WorseReflection\Core\Exception\NotFound;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionInterface;
use Phpactor202301\Phpactor\WorseReflection\Core\ServiceLocator;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\ClassDeclaration;
use Phpactor202301\Microsoft\PhpParser\Node\QualifiedName;
use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Microsoft\PhpParser\Node\Statement\InterfaceDeclaration;
/**
 * @extends AbstractReflectionCollection<ReflectionInterface>
 */
class ReflectionInterfaceCollection extends AbstractReflectionCollection
{
    /**
     * @param array<string,bool> $visited
     */
    public static function fromInterfaceDeclaration(ServiceLocator $serviceLocator, InterfaceDeclaration $interface, array $visited = []) : self
    {
        return self::fromBaseClause($serviceLocator, $interface->interfaceBaseClause, $visited);
    }
    public static function fromClassDeclaration(ServiceLocator $serviceLocator, ClassDeclaration $class) : self
    {
        return self::fromBaseClause($serviceLocator, $class->classInterfaceClause, []);
    }
    /**
     * @param mixed $baseClause
     * @param array<string,bool> $visited
     */
    private static function fromBaseClause(ServiceLocator $serviceLocator, $baseClause, array $visited) : self
    {
        if (!$baseClause instanceof ClassInterfaceClause && !$baseClause instanceof InterfaceBaseClause) {
            return new self([]);
        }
        $items = [];
        $interfaceNameList = $baseClause->interfaceNameList;
        if (null === $interfaceNameList) {
            return new self([]);
        }
        $children = $interfaceNameList->children;
        if (!$children) {
            return new self([]);
        }
        foreach ($children as $name) {
            if (\false === $name instanceof QualifiedName) {
                continue;
            }
            try {
                $interface = $serviceLocator->reflector()->reflectInterface(ClassName::fromString((string) $name->getResolvedName()), $visited);
                $items[$interface->name()->full()] = $interface;
            } catch (NotFound) {
            }
        }
        return new self($items);
    }
}
/**
 * @extends AbstractReflectionCollection<ReflectionInterface>
 */
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\Collection\\ReflectionInterfaceCollection', 'Phpactor\\WorseReflection\\Core\\Reflection\\Collection\\ReflectionInterfaceCollection', \false);
