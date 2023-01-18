<?php

namespace Phpactor202301\Phpactor\Extension\Navigation\Navigator;

class ChainNavigator implements Navigator
{
    /**
     * @param \Phpactor\Extension\Navigation\Navigator\Navigator[] $navigators
     */
    public function __construct(private array $navigators)
    {
    }
    public function destinationsFor(string $path) : array
    {
        $destinations = [];
        foreach ($this->navigators as $navigator) {
            $destinations = \array_merge($destinations, $navigator->destinationsFor($path));
        }
        return $destinations;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Navigation\\Navigator\\ChainNavigator', 'Phpactor\\Extension\\Navigation\\Navigator\\ChainNavigator', \false);
