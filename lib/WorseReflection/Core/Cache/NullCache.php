<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core\Cache;

use Closure;
use Phpactor202301\Phpactor\WorseReflection\Core\Cache;
class NullCache implements Cache
{
    public function getOrSet(string $key, Closure $closure)
    {
        return $closure();
    }
    public function purge() : void
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Cache\\NullCache', 'Phpactor\\WorseReflection\\Core\\Cache\\NullCache', \false);
