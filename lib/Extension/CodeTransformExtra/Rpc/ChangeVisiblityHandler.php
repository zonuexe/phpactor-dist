<?php

namespace Phpactor202301\Phpactor\Extension\CodeTransformExtra\Rpc;

use Phpactor202301\Phpactor\CodeTransform\Domain\Refactor\ChangeVisiblity;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
use Phpactor202301\Phpactor\Extension\Rpc\Handler;
use Phpactor202301\Phpactor\Extension\Rpc\Response\UpdateFileSourceResponse;
use Phpactor202301\Phpactor\MapResolver\Resolver;
class ChangeVisiblityHandler implements Handler
{
    const NAME = 'change_visibility';
    const PARAM_PATH = 'path';
    const PARAM_SOURCE = 'source';
    const PARAM_OFFSET = 'offset';
    public function __construct(private ChangeVisiblity $changeVisiblity)
    {
    }
    public function name() : string
    {
        return self::NAME;
    }
    public function configure(Resolver $resolver) : void
    {
        $resolver->setRequired([self::PARAM_PATH, self::PARAM_SOURCE, self::PARAM_OFFSET]);
        $resolver->setTypes([self::PARAM_OFFSET => 'integer']);
    }
    public function handle(array $arguments)
    {
        $source = $arguments[self::PARAM_SOURCE];
        $source = SourceCode::fromStringAndPath($source, $arguments[self::PARAM_PATH]);
        $source = $this->changeVisiblity->changeVisiblity($source, $arguments[self::PARAM_OFFSET]);
        return UpdateFileSourceResponse::fromPathOldAndNewSource($source->path(), $arguments[self::PARAM_SOURCE], (string) $source);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\CodeTransformExtra\\Rpc\\ChangeVisiblityHandler', 'Phpactor\\Extension\\CodeTransformExtra\\Rpc\\ChangeVisiblityHandler', \false);
