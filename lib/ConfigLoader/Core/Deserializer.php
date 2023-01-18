<?php

namespace Phpactor202301\Phpactor\ConfigLoader\Core;

interface Deserializer
{
    public function deserialize(string $contents) : array;
}
\class_alias('Phpactor202301\\Phpactor\\ConfigLoader\\Core\\Deserializer', 'Phpactor\\ConfigLoader\\Core\\Deserializer', \false);
