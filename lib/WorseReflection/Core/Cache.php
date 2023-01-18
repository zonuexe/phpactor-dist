<?php

namespace Phpactor202301\Phpactor\WorseReflection\Core;

use Closure;
interface Cache
{
    /**
     * @template T
     * @param Closure(): T $closure
     * @return T
     */
    public function getOrSet(string $key, Closure $closure);
    public function purge() : void;
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Core\\Cache', 'Phpactor\\WorseReflection\\Core\\Cache', \false);
