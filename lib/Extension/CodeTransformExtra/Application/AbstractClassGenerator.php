<?php

namespace Phpactor202301\Phpactor\Extension\CodeTransformExtra\Application;

use Phpactor202301\Phpactor\Extension\Core\Application\Helper\ClassFileNormalizer;
use Phpactor202301\Phpactor\CodeTransform\Domain\Generators;
use Phpactor202301\Phpactor\Filesystem\Domain\FilePath;
use Phpactor202301\Psr\Log\LoggerInterface;
use Phpactor202301\Psr\Log\NullLogger;
class AbstractClassGenerator
{
    private LoggerInterface $logger;
    public function __construct(protected ClassFileNormalizer $normalizer, protected Generators $generators, LoggerInterface $logger = null)
    {
        $this->logger = $logger ?: new NullLogger();
    }
    public function availableGenerators()
    {
        return $this->generators->names();
    }
    protected function logger() : LoggerInterface
    {
        return $this->logger;
    }
    protected function writeFile(string $filePath, string $code, bool $overwrite) : void
    {
        if (\false === $overwrite && \file_exists($filePath) && 0 !== \filesize($filePath)) {
            throw new Exception\FileAlreadyExists(\sprintf('File "%s" already exists and is non-empty', $filePath));
        }
        if (!\file_exists(\dirname($filePath))) {
            \mkdir(\dirname($filePath), 0777, \true);
        }
        \file_put_contents(FilePath::fromString($filePath), (string) $code);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\CodeTransformExtra\\Application\\AbstractClassGenerator', 'Phpactor\\Extension\\CodeTransformExtra\\Application\\AbstractClassGenerator', \false);
