<?php

namespace Phpactor202301\Phpactor\Extension\Navigation\Navigator;

use Phpactor202301\Phpactor\PathFinder\Exception\NoMatchingSourceException;
use Phpactor202301\Phpactor\PathFinder\PathFinder;
class PathFinderNavigator implements Navigator
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
\class_alias('Phpactor202301\\Phpactor\\Extension\\Navigation\\Navigator\\PathFinderNavigator', 'Phpactor\\Extension\\Navigation\\Navigator\\PathFinderNavigator', \false);
