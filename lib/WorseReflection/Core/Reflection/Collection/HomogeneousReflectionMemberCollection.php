<?php

namespace Phpactor\WorseReflection\Core\Reflection\Collection;

use Closure;
use Phpactor\WorseReflection\Core\ClassName;
use Phpactor\WorseReflection\Core\Reflection\ReflectionEnumCase;
use Phpactor\WorseReflection\Core\Reflection\ReflectionMember;
use Phpactor\WorseReflection\Core\Reflection\ReflectionMethod;
use Phpactor\WorseReflection\Core\Reflection\ReflectionProperty;
use Phpactor\WorseReflection\Core\Visibility;
/**
 * @template T of ReflectionMember
 * @extends AbstractReflectionCollection<T>
 * @implements ReflectionMemberCollection<T>
 */
class HomogeneousReflectionMemberCollection extends \Phpactor\WorseReflection\Core\Reflection\Collection\AbstractReflectionCollection implements \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection
{
    /**
     * @return static
     * @param ReflectionMember[] $members
     */
    public static function fromMembers(array $members) : \Phpactor\WorseReflection\Core\Reflection\Collection\HomogeneousReflectionMemberCollection
    {
        return new static($members);
    }
    /**
     * @return static
     * @param Visibility[] $visibilities
     */
    public function byVisibilities(array $visibilities) : \Phpactor\WorseReflection\Core\Reflection\Collection\HomogeneousReflectionMemberCollection
    {
        $items = [];
        foreach ($this as $key => $item) {
            foreach ($visibilities as $visibility) {
                if ($item->visibility() != $visibility) {
                    continue;
                }
                $items[$key] = $item;
            }
        }
        return new static($items);
    }
    /**
     * @return static
     */
    public function belongingTo(ClassName $class) : \Phpactor\WorseReflection\Core\Reflection\Collection\HomogeneousReflectionMemberCollection
    {
        return new static(\array_filter($this->items, function (ReflectionMember $item) use($class) {
            return $item->declaringClass()->name() == $class;
        }));
    }
    /**
     * @return static
     */
    public function atOffset(int $offset) : \Phpactor\WorseReflection\Core\Reflection\Collection\HomogeneousReflectionMemberCollection
    {
        return new static(\array_filter($this->items, function (ReflectionMember $item) use($offset) {
            return $item->position()->start()->toInt() <= $offset && $item->position()->end()->toInt() >= $offset;
        }));
    }
    /**
     * @return static
     */
    public function byName(string $name) : \Phpactor\WorseReflection\Core\Reflection\Collection\HomogeneousReflectionMemberCollection
    {
        if ($this->has($name)) {
            return new static([$this->get($name)]);
        }
        return new static([]);
    }
    /**
     * @return static
     */
    public function virtual() : \Phpactor\WorseReflection\Core\Reflection\Collection\HomogeneousReflectionMemberCollection
    {
        return new static(\array_filter($this->items, function (ReflectionMember $member) {
            return \true === $member->isVirtual();
        }));
    }
    /**
     * @return static
     */
    public function real() : \Phpactor\WorseReflection\Core\Reflection\Collection\HomogeneousReflectionMemberCollection
    {
        return new static(\array_filter($this->items, function (ReflectionMember $member) {
            return \false === $member->isVirtual();
        }));
    }
    public function methods() : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMethodCollection
    {
        return new \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMethodCollection(\array_filter($this->items, function (ReflectionMember $member) {
            return $member instanceof ReflectionMethod;
        }));
    }
    public function constants() : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionConstantCollection
    {
        return new \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionConstantCollection(\array_filter($this->items, function (ReflectionMember $member) {
            return $member instanceof \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionConstant;
        }));
    }
    public function properties() : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionPropertyCollection
    {
        return new \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionPropertyCollection(\array_filter($this->items, function (ReflectionMember $member) {
            return $member instanceof ReflectionProperty;
        }));
    }
    public function enumCases() : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionEnumCaseCollection
    {
        return new \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionEnumCaseCollection(\array_filter($this->items, function (ReflectionMember $member) {
            return $member instanceof ReflectionEnumCase;
        }));
    }
    /**
     * @return static
     */
    public function byMemberType(string $type) : \Phpactor\WorseReflection\Core\Reflection\Collection\HomogeneousReflectionMemberCollection
    {
        return new static(\array_filter($this->items, function (ReflectionMember $member) use($type) {
            return $type === $member->memberType();
        }));
    }
    public function map(Closure $mapper)
    {
        return new static(\array_map($mapper, $this->items));
    }
    protected function collectionType() : string
    {
        return \Phpactor\WorseReflection\Core\Reflection\Collection\HomogeneousReflectionMemberCollection::class;
    }
}
