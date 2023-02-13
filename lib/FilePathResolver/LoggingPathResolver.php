<?php

namespace Phpactor\FilePathResolver;

use PhpactorDist\Psr\Log\LogLevel;
use PhpactorDist\Psr\Log\LoggerInterface;
class LoggingPathResolver implements \Phpactor\FilePathResolver\PathResolver
{
    public function __construct(private \Phpactor\FilePathResolver\PathResolver $pathResolver, private LoggerInterface $logger, private string $level = LogLevel::DEBUG)
    {
    }
    public function resolve(string $path) : string
    {
        $resolvedPath = $this->pathResolver->resolve($path);
        $this->logger->log($this->level, \sprintf('Resolved path "%s" to "%s"', $path, $resolvedPath));
        return $resolvedPath;
    }
}
