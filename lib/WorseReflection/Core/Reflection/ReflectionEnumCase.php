<?php

namespace Phpactor\WorseReflection\Core\Reflection;

use Phpactor\WorseReflection\Core\Type;
interface ReflectionEnumCase extends \Phpactor\WorseReflection\Core\Reflection\ReflectionMember
{
    public function value() : Type;
}
