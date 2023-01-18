<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Server\Transmitter;

use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\Message;
interface MessageTransmitter
{
    public function transmit(Message $response) : void;
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Server\\Transmitter\\MessageTransmitter', 'Phpactor\\LanguageServer\\Core\\Server\\Transmitter\\MessageTransmitter', \false);
