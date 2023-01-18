<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Reflection;

use Phpactor202301\Phpactor\WorseReflection\Core\Deprecation;
use Phpactor202301\Phpactor\WorseReflection\Core\Position;
use Phpactor202301\Phpactor\WorseReflection\Core\ClassName;
use Phpactor202301\Phpactor\WorseReflection\Core\SourceCode;
use Phpactor202301\Phpactor\WorseReflection\Core\DocBlock\DocBlock;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMethodCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection;
use Phpactor202301\Phpactor\WorseReflection\Core\TemplateMap;
use Phpactor202301\Phpactor\WorseReflection\Core\Type\ReflectedClassType;
interface ReflectionClassLike extends ReflectionNode
{
    public function position() : Position;
    public function name() : ClassName;
    public function methods(ReflectionClassLike $contextClass = null) : ReflectionMethodCollection;
    /**
     * @return ReflectionMemberCollection<ReflectionMember>
     */
    public function members() : ReflectionMemberCollection;
    /**
     * @return ReflectionMemberCollection<ReflectionMember>
     */
    public function ownMembers() : ReflectionMemberCollection;
    public function sourceCode() : SourceCode;
    public function isInterface() : bool;
    public function isInstanceOf(ClassName $className) : bool;
    public function isTrait() : bool;
    public function isClass() : bool;
    public function isEnum() : bool;
    public function isConcrete() : bool;
    public function docblock() : DocBlock;
    public function deprecation() : Deprecation;
    public function templateMap() : TemplateMap;
    public function type() : ReflectedClassType;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionClassLike', 'Phpactor\\WorseReflection\\Core\\Reflection\\ReflectionClassLike', \false);
