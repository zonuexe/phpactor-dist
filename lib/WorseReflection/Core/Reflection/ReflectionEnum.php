<?php

namespace Phpactor\WorseReflection\Core\Reflection;

use Phpactor\WorseReflection\Core\DocBlock\DocBlock;
use Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionEnumCaseCollection;
use Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionPropertyCollection;
use Phpactor\WorseReflection\Core\Type;
interface ReflectionEnum extends \Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike
{
    public function docblock() : DocBlock;
    public function properties() : ReflectionPropertyCollection;
    public function cases() : ReflectionEnumCaseCollection;
    public function isBacked() : bool;
    public function backedType() : Type;
}
