<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Server\Transmitter;

use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\Message;
final class NullMessageTransmitter implements MessageTransmitter
{
    public function transmit(Message $response) : void
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Server\\Transmitter\\NullMessageTransmitter', 'Phpactor\\LanguageServer\\Core\\Server\\Transmitter\\NullMessageTransmitter', \false);
