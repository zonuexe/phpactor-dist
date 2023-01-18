<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Server\Transmitter;

use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\Message;
interface TestMessageTransmitterStack
{
    public function shift() : ?Message;
    public function clear() : void;
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Server\\Transmitter\\TestMessageTransmitterStack', 'Phpactor\\LanguageServer\\Core\\Server\\Transmitter\\TestMessageTransmitterStack', \false);
