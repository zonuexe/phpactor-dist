<?php

namespace Phpactor\WorseReflection\Core\Reflection;

use Phpactor\WorseReflection\Core\Deprecation;
use Phpactor\WorseReflection\Core\Position;
use Phpactor\WorseReflection\Core\ClassName;
use Phpactor\WorseReflection\Core\SourceCode;
use Phpactor\WorseReflection\Core\DocBlock\DocBlock;
use Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMethodCollection;
use Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection;
use Phpactor\WorseReflection\Core\TemplateMap;
use Phpactor\WorseReflection\Core\Type\ReflectedClassType;
interface ReflectionClassLike extends \Phpactor\WorseReflection\Core\Reflection\ReflectionNode
{
    public function position() : Position;
    public function name() : ClassName;
    public function methods(\Phpactor\WorseReflection\Core\Reflection\ReflectionClassLike $contextClass = null) : ReflectionMethodCollection;
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
