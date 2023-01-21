<?php

namespace Phpactor\WorseReflection\Core\Reflection;

use Phpactor\WorseReflection\Core\DocBlock\DocBlock;
use Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionPropertyCollection;
use Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionTraitCollection;
interface ReflectionTrait extends \Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike
{
    public function docblock() : DocBlock;
    public function properties() : ReflectionPropertyCollection;
    public function traits() : ReflectionTraitCollection;
}
