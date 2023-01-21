<?php

namespace Phpactor\WorseReflection\Core\Reflection;

use Phpactor\WorseReflection\Core\Name;
use Phpactor\WorseReflection\Core\NameImports;
use Phpactor\WorseReflection\Core\Type;
interface ReflectionScope
{
    public function nameImports() : NameImports;
    public function resolveLocalName(Name $type) : Name;
    /**
     * @param null|Type|string $type
     */
    public function resolveFullyQualifiedName($type, \Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike $classLike = null) : Type;
    public function resolveLocalType(Type $type) : Type;
}
