<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Type;

use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMember;
interface ClassLikeType
{
    public function name() : ClassName;
    /**
     * @return ReflectionMemberCollection<ReflectionMember>
     */
    public function members() : ReflectionMemberCollection;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Type\\ClassLikeType', 'Phpactor\\WorseReflection\\Core\\Type\\ClassLikeType', \false);
