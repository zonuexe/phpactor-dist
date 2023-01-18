<?php

namespace Phpactor202301\Phpactor\Extension\CodeTransform\Rpc;

use Phpactor202301\Phpactor\CodeTransform\Domain\GenerateNew;
use Phpactor202301\Phpactor\CodeTransform\Domain\SourceCode;
class ClassNewHandler extends AbstractClassGenerateHandler
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
\class_alias('Phpactor202301\\Phpactor\\Extension\\CodeTransform\\Rpc\\ClassNewHandler', 'Phpactor\\Extension\\CodeTransform\\Rpc\\ClassNewHandler', \false);
