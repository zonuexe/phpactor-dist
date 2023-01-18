<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\Phpactor\MemberProvider;

use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ChainReflectionMemberCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMember;
use Phpactor202301\Phpactor\WorseReflection\Core\ServiceLocator;
use Phpactor202301\Phpactor\WorseReflection\Core\Virtual\ReflectionMemberProvider;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike;
class DocblockMemberProvider implements ReflectionMemberProvider
{
    /**
     * @return ReflectionMemberCollection<ReflectionMember>
     */
    public function provideMembers(ServiceLocator $locator, ReflectionClassLike $class) : ReflectionMemberCollection
    {
        return ChainReflectionMemberCollection::fromCollections([$class->docblock()->methods($class), $class->docblock()->properties($class)]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\Phpactor\\MemberProvider\\DocblockMemberProvider', 'Phpactor\\WorseReflection\\Bridge\\Phpactor\\MemberProvider\\DocblockMemberProvider', \false);
