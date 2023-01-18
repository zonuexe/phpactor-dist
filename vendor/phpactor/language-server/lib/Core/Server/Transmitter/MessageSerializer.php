<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Server\Transmitter;

use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\Message;
interface MessageSerializer
{
    public function serialize(Message $message) : string;
    /**
     * Normalize a message before being serialized by recursively applying array_filter
     * and removing null values
     *
     * @param mixed $message
     *
     * @return mixed
     */
    public function normalize($message);
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Server\\Transmitter\\MessageSerializer', 'Phpactor\\LanguageServer\\Core\\Server\\Transmitter\\MessageSerializer', \false);
