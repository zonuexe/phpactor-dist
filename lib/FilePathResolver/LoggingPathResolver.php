<?php

namespace Phpactor202301\Phpactor\FilePathResolver;

use Phpactor202301\Psr\Log\LogLevel;
use Phpactor202301\Psr\Log\LoggerInterface;
class LoggingPathResolver implements PathResolver
{
    public function __construct(private PathResolver $pathResolver, private LoggerInterface $logger, private string $level = LogLevel::DEBUG)
    {
    }
    public function resolve(string $path) : string
    {
        $resolvedPath = $this->pathResolver->resolve($path);
        $this->logger->log($this->level, \sprintf('Resolved path "%s" to "%s"', $path, $resolvedPath));
        return $resolvedPath;
    }
}
\class_alias('Phpactor202301\\Phpactor\\FilePathResolver\\LoggingPathResolver', 'Phpactor\\FilePathResolver\\LoggingPathResolver', \false);
