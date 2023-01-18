<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\TolerantParser\Parser;

use Phpactor202301\Microsoft\PhpParser\Node\SourceFileNode;
use Phpactor202301\Microsoft\PhpParser\Parser;
use Phpactor202301\Phpactor\WorseReflection\Core\Cache;
use Phpactor202301\Phpactor\WorseReflection\Core\Cache\TtlCache;
class CachedParser extends Parser
{
    private Cache $cache;
    public function __construct(Cache $cache = null)
    {
        $this->cache = $cache ?: new TtlCache();
        parent::__construct();
    }
    public function parseSourceFile(string $source, string $uri = null) : SourceFileNode
    {
        return $this->cache->getOrSet('__parser__' . \md5($source), function () use($source, $uri) {
            return parent::parseSourceFile($source, $uri);
        });
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Parser\\CachedParser', 'Phpactor\\WorseReflection\\Bridge\\TolerantParser\\Parser\\CachedParser', \false);
