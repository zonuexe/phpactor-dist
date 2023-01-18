<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection;

use Phpactor202301\Phpactor\WorseReflection\Core\Name;
use Phpactor202301\Phpactor\WorseReflection\Core\NameImports;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
interface ReflectionScope
{
    public function nameImports() : NameImports;
    public function resolveLocalName(Name $type) : Name;
    /**
     * @param null|Type|string $type
     */
    public function resolveFullyQualifiedName($type, ReflectionClassLike $classLike = null) : Type;
    public function resolveLocalType(Type $type) : Type;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionScope', 'Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionScope', \false);
