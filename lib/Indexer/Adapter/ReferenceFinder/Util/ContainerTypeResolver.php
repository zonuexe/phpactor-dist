<?php

namespace Phpactor202301\Phpactor\Indexer\Adapter\ReferenceFinder\Util;

use Phpactor202301\Phpactor\WorseReflection\Core\Exception\NotFound;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMember;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflector\ClassReflector;
class ContainerTypeResolver
{
    public function __construct(private ClassReflector $reflector)
    {
    }
    /**
     * @param ReflectionMember::TYPE_* $memberType
     */
    public function resolveDeclaringContainerType(string $memberType, string $memberName, ?string $containerFqn) : ?string
    {
        if (null === $containerFqn) {
            return null;
        }
        try {
            $classLike = $this->reflector->reflectClassLike($containerFqn);
            $members = $classLike->members()->byMemberType($memberType);
            return $members->get($memberName)->original()->declaringClass()->name()->__toString();
        } catch (NotFound) {
            return $containerFqn;
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\Indexer\\Adapter\\ReferenceFinder\\Util\\ContainerTypeResolver', 'Phpactor\\Indexer\\Adapter\\ReferenceFinder\\Util\\ContainerTypeResolver', \false);
