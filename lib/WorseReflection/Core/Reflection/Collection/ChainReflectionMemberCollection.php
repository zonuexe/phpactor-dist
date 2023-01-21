<?php

namespace Phpactor\WorseReflection\Core\Reflection\Collection;

use AppendIterator;
use Closure;
use Phpactor\WorseReflection\Core\ClassName;
use Phpactor\WorseReflection\Core\Exception\ItemNotFound;
use Phpactor\WorseReflection\Core\Reflection\ReflectionConstant;
use Phpactor\WorseReflection\Core\Reflection\ReflectionEnumCase;
use Phpactor\WorseReflection\Core\Reflection\ReflectionMethod;
use Phpactor\WorseReflection\Core\Reflection\ReflectionProperty;
use Phpactor\WorseReflection\Core\Reflection\ReflectionMember;
use Phpactor\WorseReflection\Core\Visibility;
use Traversable;
/**
 * @template T of ReflectionMemberCollection
 * @implements ReflectionMemberCollection<ReflectionMember>
 */
final class ChainReflectionMemberCollection implements \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection
{
    /**
     * @var array<ReflectionMemberCollection<ReflectionMember>>
     */
    private array $collections = [];
    /**
     * @param array<T> $collections
     */
    private final function __construct(array $collections)
    {
        foreach ($collections as $collection) {
            $this->add($collection);
        }
    }
    /**
     * @param array<T> $collections
     * @return self<T>
     */
    public static function fromCollections(array $collections) : self
    {
        return new static($collections);
    }
    /**
     * @return AppendIterator<ReflectionMember>
     */
    public function getIterator() : Traversable
    {
        $iterator = new AppendIterator();
        foreach ($this->collections as $collection) {
            /** @phpstan-ignore-next-line */
            $iterator->append($collection->getIterator());
        }
        return $iterator;
    }
    public function count() : int
    {
        return \array_reduce($this->collections, function ($acc, \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection $collection) {
            $acc += \count($collection);
            return $acc;
        }, 0);
    }
    public function keys() : array
    {
        return \array_reduce($this->collections, function ($acc, \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection $collection) {
            $acc = \array_merge($acc, $collection->keys());
            return $acc;
        }, []);
    }
    /**
     * @param ReflectionMemberCollection<ReflectionMember> $collection
     * @phpstan-ignore-next-line
     */
    public function merge(\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionCollection $collection) : self
    {
        $new = new static($this->collections);
        $new->add($collection);
        return $new;
    }
    public function get(string $name)
    {
        $known = [];
        foreach ($this->collections as $collection) {
            $known = \array_merge($known, $collection->keys());
            if ($collection->has($name)) {
                return $collection->get($name);
            }
        }
        throw new ItemNotFound(\sprintf('Unknown item "%s", known items: "%s"', $name, \implode('", "', $known)));
    }
    public function first()
    {
        foreach ($this->collections as $collection) {
            if ($collection->count()) {
                return $collection->first();
            }
        }
        throw new ItemNotFound('None of the collections have items');
    }
    public function last()
    {
        $last = null;
        foreach ($this->collections as $collection) {
            $last = $collection->last();
        }
        if ($last) {
            return $last;
        }
        throw new ItemNotFound('None of the collections have items');
    }
    public function has(string $name) : bool
    {
        foreach ($this->collections as $collection) {
            if ($collection->has($name)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @return ReflectionMemberCollection<ReflectionMember>
     * @param array<Visibility> $visibilities
     */
    public function byVisibilities(array $visibilities) : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection
    {
        $collections = [];
        foreach ($this->collections as $collection) {
            $collections[] = $collection->byVisibilities($visibilities);
        }
        return new static($collections);
    }
    public function belongingTo(ClassName $class) : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection
    {
        $collections = [];
        foreach ($this->collections as $collection) {
            $collections[] = $collection->belongingTo($class);
        }
        return new static($collections);
    }
    public function atOffset(int $offset) : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection
    {
        $collections = [];
        foreach ($this->collections as $collection) {
            $collections[] = $collection->atOffset($offset);
        }
        return new static($collections);
    }
    public function byName(string $name) : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection
    {
        $collections = [];
        foreach ($this->collections as $collection) {
            $collections[] = $collection->byName($name);
        }
        return new static($collections);
    }
    public function virtual() : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection
    {
        $collections = [];
        foreach ($this->collections as $collection) {
            $collections[] = $collection->virtual();
        }
        return new static($collections);
    }
    public function real() : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection
    {
        $collections = [];
        foreach ($this->collections as $collection) {
            $collections[] = $collection->real();
        }
        return new static($collections);
    }
    public function methods() : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMethodCollection
    {
        return \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMethodCollection::fromReflections(\iterator_to_array($this->byMemberClass(ReflectionMethod::class)));
    }
    public function properties() : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionPropertyCollection
    {
        return \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionPropertyCollection::fromReflections(\iterator_to_array($this->byMemberClass(ReflectionProperty::class)));
    }
    public function constants() : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionConstantCollection
    {
        return \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionConstantCollection::fromReflections(\iterator_to_array($this->byMemberClass(ReflectionConstant::class)));
    }
    public function enumCases() : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionEnumCaseCollection
    {
        return \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionEnumCaseCollection::fromReflections(\iterator_to_array($this->byMemberClass(ReflectionEnumCase::class)));
    }
    public function byMemberClass(string $fqn) : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionCollection
    {
        $items = [];
        foreach ($this->collections as $collection) {
            foreach ($collection->byMemberClass($fqn) as $key => $reflection) {
                $items[$key] = $reflection;
            }
        }
        /** @phpstan-ignore-next-line It's _fine_ */
        return \Phpactor\WorseReflection\Core\Reflection\Collection\HomogeneousReflectionMemberCollection::fromReflections($items);
    }
    /**
     * @param ReflectionMember::TYPE_* $type
     */
    public function byMemberType(string $type) : \Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection
    {
        $collections = [];
        foreach ($this->collections as $collection) {
            $collections[] = $collection->byMemberType($type);
        }
        return new static($collections);
    }
    public function map(Closure $mapper)
    {
        $collections = [];
        foreach ($this->collections as $collection) {
            $collections[] = $collection->map($mapper);
        }
        return new static($collections);
    }
    /**
     * @param ReflectionMemberCollection<ReflectionMember> $collection
     */
    private function add(\Phpactor\WorseReflection\Core\Reflection\Collection\ReflectionMemberCollection $collection) : void
    {
        $this->collections[] = $collection;
    }
}
