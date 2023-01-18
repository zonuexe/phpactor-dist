<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Virtual;

use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike;
use Phpactor202301\Phpactor\WorseReflection\Core\ServiceLocator;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMember;
interface ReflectionMemberProvider
{
    /**
     * @return ReflectionMemberCollection<ReflectionMember>
     */
    public function provideMembers(ServiceLocator $locator, ReflectionClassLike $class) : ReflectionMemberCollection;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Virtual\\ReflectionMemberProvider', 'Phpactor\\WorseReflection\\Core\\Virtual\\ReflectionMemberProvider', \false);
