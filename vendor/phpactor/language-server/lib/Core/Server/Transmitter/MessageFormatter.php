<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Server\Transmitter;

use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\Message;
interface MessageFormatter
{
    public function format(Message $message) : string;
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Server\\Transmitter\\MessageFormatter', 'Phpactor\\LanguageServer\\Core\\Server\\Transmitter\\MessageFormatter', \false);
