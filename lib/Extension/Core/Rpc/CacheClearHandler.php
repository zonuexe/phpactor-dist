<?php

namespace Phpactor202301\Phpactor\Extension\Core\Rpc;

use Phpactor202301\Phpactor\MapResolver\Resolver;
use Phpactor202301\Phpactor\Extension\Rpc\Handler;
use Phpactor202301\Phpactor\Extension\Core\Application\CacheClear;
use Phpactor202301\Phpactor\Extension\Rpc\Response\EchoResponse;
class CacheClearHandler implements Handler
{
    const NAME = 'cache_clear';
    public function __construct(private CacheClear $cacheClear)
    {
    }
    public function name() : string
    {
        return self::NAME;
    }
    public function configure(Resolver $resolver) : void
    {
    }
    public function handle(array $arguments) : EchoResponse
    {
        $this->cacheClear->clearCache();
        return EchoResponse::fromMessage(\sprintf('Cache cleared: %s', $this->cacheClear->cachePath()));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\Core\\Rpc\\CacheClearHandler', 'Phpactor\\Extension\\Core\\Rpc\\CacheClearHandler', \false);
