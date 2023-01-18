<?php

namespace Phpactor202301\Phpactor\Extension\Rpc;

class RpcVersion
{
    const MAJOR = 1;
    const MINOR = 0;
    const PATCH = 0;
    public static function asString()
    {
        return \implode('.', [self::MAJOR, self::MINOR, self::PATCH]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Rpc\\RpcVersion', 'Phpactor\\Extension\\Rpc\\RpcVersion', \false);
