<?php

namespace Phpactor202301\Phpactor\LanguageServer\Core\Server\Client;

use Phpactor202301\Phpactor\LanguageServer\Core\Server\RpcClient;
final class DiagnosticsClient
{
    /**
     * @var RpcClient
     */
    private $client;
    public function __construct(RpcClient $client)
    {
        $this->client = $client;
    }
    public function publishDiagnostics(string $uri, ?int $version, array $diagnostics) : void
    {
        $this->client->notification('textDocument/publishDiagnostics', ['uri' => $uri, 'version' => $version, 'diagnostics' => $diagnostics]);
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Core\\Server\\Client\\DiagnosticsClient', 'Phpactor\\LanguageServer\\Core\\Server\\Client\\DiagnosticsClient', \false);
