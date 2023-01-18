<?php

namespace Phpactor202301\Phpactor\WorseReflection\Bridge\Phpactor\DocblockParser;

use Phpactor202301\Phpactor\WorseReflection\Core\Cache;
use Phpactor202301\Phpactor\WorseReflection\Core\DocBlock\DocBlock;
use Phpactor202301\Phpactor\WorseReflection\Core\DocBlock\DocBlockFactory;
use Phpactor202301\Phpactor\WorseReflection\Core\DocBlock\PlainDocblock;
use Phpactor202301\Phpactor\WorseReflection\Core\Reflection\ReflectionScope;
class CachedParserFactory implements DocBlockFactory
{
    public function __construct(private DocBlockFactory $innerFactory, private Cache $cache)
    {
    }
    public function create(string $docblock, ReflectionScope $scope) : DocBlock
    {
        if (!\trim($docblock)) {
            return new PlainDocblock('');
        }
        return $this->cache->getOrSet('docblock_' . $docblock, function () use($docblock, $scope) {
            return $this->innerFactory->create($docblock, $scope);
        });
    }
}
\class_alias('Phpactor202301\\Phpactor\\WorseReflection\\Bridge\\Phpactor\\DocblockParser\\CachedParserFactory', 'Phpactor\\WorseReflection\\Bridge\\Phpactor\\DocblockParser\\CachedParserFactory', \false);
