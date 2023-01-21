<?php

namespace Phpactor\WorseReflection\Core\Reflection\Collection;

use Closure;
use Phpactor\WorseReflection\Core\ClassName;
use Phpactor\WorseReflection\Core\Reflection\ReflectionMember;
use Phpactor\WorseReflection\Core\Visibility;
/**
 * @template T of ReflectionMember
 * @extends ReflectionCollection<T>
 */
interface ReflectionMemberCollection extends \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionCollection
{
    /**
     * @return static
     * @param Visibility[] $visibilities
     */
    public function byVisibilities(array $visibilities) : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection;
    /**
     * @return static
     */
    public function belongingTo(ClassName $class) : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection;
    /**
     * @return static
     */
    public function atOffset(int $offset) : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection;
    /**
     * @return static
     */
    public function byName(string $name) : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection;
    /**
     * @return static
     */
    public function virtual() : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection;
    /**
     * @return static
     */
    public function real() : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection;
    public function methods() : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMethodCollection;
    public function properties() : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionPropertyCollection;
    public function constants() : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionConstantCollection;
    public function enumCases() : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionEnumCaseCollection;
    /**
     * @return static
     */
    public function byMemberType(string $type) : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionCollection;
    /**
     * @param Closure(T): ReflectionMember $mapper
     * @return static
     */
    public function map(Closure $mapper);
}
