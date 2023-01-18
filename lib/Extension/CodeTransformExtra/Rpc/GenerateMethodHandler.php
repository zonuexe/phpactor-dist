<?php

namespace Phpactor202301\Phpactor\Extension\CodeTransformExtra\Rpc;

use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\GenerateMethod;
use Phpactor202301\Phpactor\MapResolver\Resolver;
use Phpactor202301\Phpactor\Extension\Rpc\Response\UpdateFileSourceResponse;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\Extension\Rpc\Handler\AbstractHandler;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
class GenerateMethodHandler extends AbstractHandler
{
    const NAME = 'generate_method';
    const PARAM_OFFSET = 'offset';
    const PARAM_SOURCE = 'source';
    const PARAM_PATH = 'path';
    public function __construct(private GenerateMethod $generateMethod)
    {
    }
    public function name() : string
    {
        return self::NAME;
    }
    public function configure(Resolver $resolver) : void
    {
        $resolver->setRequired([self::PARAM_PATH, self::PARAM_SOURCE, self::PARAM_OFFSET]);
    }
    public function handle(array $arguments)
    {
        $textDocumentEdits = $this->generateMethod->generateMethod(SourceCode::fromStringAndPath($arguments[self::PARAM_SOURCE], $arguments[self::PARAM_PATH]), $arguments[self::PARAM_OFFSET]);
        $originalSource = $this->determineOriginalSource($textDocumentEdits->uri(), $arguments);
        return UpdateFileSourceResponse::fromPathOldAndNewSource($textDocumentEdits->uri()->path(), $originalSource, $textDocumentEdits->textEdits()->apply((string) $originalSource));
    }
    private function determineOriginalSource(TextDocumentUri $uri, array $arguments)
    {
        $originalSource = $uri->path() === $arguments[self::PARAM_PATH] ? $arguments[self::PARAM_SOURCE] : \file_get_contents($uri->path());
        return $originalSource;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\CodeTransformExtra\\Rpc\\GenerateMethodHandler', 'Phpactor\\Extension\\CodeTransformExtra\\Rpc\\GenerateMethodHandler', \false);
