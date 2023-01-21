<?php

namespace Phpactor\TextDocument;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use RuntimeException;
/**
 * @implements IteratorAggregate<Location>
 */
final class Locations implements IteratorAggregate, Countable
{
    /**
     * @var Location[]
     */
    private array $locations = [];
    /**
     * @param iterable<Location> $locations
     */
    public function __construct(iterable $locations)
    {
        foreach ($locations as $location) {
            $this->add($location);
        }
    }
    /**
     * @return ArrayIterator<int,Location>
     */
    public function getIterator() : ArrayIterator
    {
        return new ArrayIterator($this->locations);
    }
    public function append(\Phpactor\TextDocument\Locations $locations) : self
    {
        $newLocations = $this->locations;
        foreach ($locations as $location) {
            $newLocations[] = $location;
        }
        return new self($newLocations);
    }
    public function count() : int
    {
        return \count($this->locations);
    }
    public function first() : \Phpactor\TextDocument\Location
    {
        if (\count($this->locations) === 0) {
            throw new RuntimeException('There are no locations in this collection');
        }
        return \reset($this->locations);
    }
    public function sorted() : self
    {
        $sortedLocations = $this->locations;
        \usort($sortedLocations, function (\Phpactor\TextDocument\Location $first, \Phpactor\TextDocument\Location $second) {
            $order = \strcmp((string) $first->uri(), (string) $second->uri());
            if (0 !== $order) {
                return $order;
            }
            return $first->offset()->toInt() - $second->offset()->toInt();
        });
        return new self($sortedLocations);
    }
    private function add(\Phpactor\TextDocument\Location $location) : self
    {
        $this->locations[] = $location;
        return $this;
    }
}
