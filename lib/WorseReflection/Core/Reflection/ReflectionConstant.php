<?php

namespace Phpactor\WorseReflection\Core\Reflection;

interface ReflectionConstant extends \Phpactor\WorseReflection\Core\Reflection\ReflectionMember
{
    /**
     * @return mixed
     */
    public function value();
}
