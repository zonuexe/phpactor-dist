<?php

namespace Phpactor\Extension\CodeTransform\Rpc;

use Phpactor\CodeTransform\Domain\GenerateNew;
use Phpactor\CodeTransform\Domain\SourceCode;
class ClassNewHandler extends \Phpactor\Extension\CodeTransform\Rpc\AbstractClassGenerateHandler
{
    const NAME = 'class_new';
    public function name() : string
    {
        return self::NAME;
    }
    public function newMessage() : string
    {
        return 'Create at: ';
    }
    protected function generate(array $arguments) : SourceCode
    {
        $generator = $this->generators->get($arguments[self::PARAM_VARIANT]);
        \assert($generator instanceof GenerateNew);
        $className = $this->className($arguments[self::PARAM_NEW_PATH]);
        return $generator->generateNew($className);
    }
}
