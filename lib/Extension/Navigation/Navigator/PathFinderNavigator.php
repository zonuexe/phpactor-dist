<?php

namespace Phpactor\Extension\Navigation\Navigator;

use Phpactor\PathFinder\Exception\NoMatchingSourceException;
use Phpactor\PathFinder\PathFinder;
class PathFinderNavigator implements \Phpactor\Extension\Navigation\Navigator\Navigator
{
    public function __construct(private PathFinder $pathFinder)
    {
    }
    public function destinationsFor(string $path) : array
    {
        try {
            return $this->pathFinder->destinationsFor($path);
        } catch (NoMatchingSourceException) {
            return [];
        }
    }
}
