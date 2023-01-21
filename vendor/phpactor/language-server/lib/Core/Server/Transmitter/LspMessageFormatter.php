<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Server\Transmitter;

use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\Message;
final class LspMessageFormatter implements MessageFormatter
{
    /**
     * @var MessageSerializer
     */
    private $serializer;
    public function __construct(?MessageSerializer $serializer = null)
    {
        $this->serializer = $serializer ?: new LspMessageSerializer();
    }
    public function format(Message $message) : string
    {
        $body = $this->serializer->serialize($message);
        $headers = ['Content-Type: application/vscode-jsonrpc; charset=utf8', 'Content-Length: ' . \strlen($body)];
        return \implode('', [\implode("\r\n", $headers), "\r\n\r\n", $body]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Server\\Transmitter\\LspMessageFormatter', 'Phpactor\\LanguageServer\\Core\\Server\\Transmitter\\LspMessageFormatter', \false);
