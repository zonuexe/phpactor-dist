<?php

namespace Phpactor\Container;

interface DiscoverableExtension extends \Phpactor\Container\OptionalExtension
{
    public function isSupported() : bool;
}
