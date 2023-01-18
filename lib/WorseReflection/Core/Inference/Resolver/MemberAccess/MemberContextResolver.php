<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Inference\Resolver\MemberAccess;

use Phpactor202301\Phpactor\WorseReflection\Core\Inference\FunctionArguments;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionMember;
use Phpactor202301\Phpactor\WorseReflection\Core\Type;
use Phpactor202301\Phpactor\WorseReflection\Reflector;
interface MemberContextResolver
{
    public function resolveMemberContext(Reflector $reflector, ReflectionMember $member, ?FunctionArguments $arguments) : ?Type;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\MemberAccess\\MemberContextResolver', 'Phpactor\\WorseReflection\\Core\\Inference\\Resolver\\MemberAccess\\MemberContextResolver', \false);
