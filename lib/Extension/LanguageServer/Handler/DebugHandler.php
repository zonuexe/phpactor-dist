<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServer\Handler;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor202301\Phpactor\Extension\LanguageServer\Status\StatusProvider;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Extension\FilePathResolver\FilePathResolverExtension;
use Phpactor202301\Phpactor\LanguageServer\Core\Diagnostics\DiagnosticsProvider;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ServerStats;
use Phpactor202301\Phpactor\LanguageServer\Core\Service\ServiceManager;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\Handler;
class DebugHandler implements Handler
{
    const METHOD_DEBUG_CONFIG = 'phpactor/debug/config';
    const METHOD_DEBUG_WORKSPACE = 'phpactor/debug/workspace';
    const METHOD_DEBUG_STATUS = 'phpactor/status';
    /**
     * @param StatusProvider[] $statusProviders
     */
    public function __construct(private Container $container, private ClientApi $client, private Workspace $workspace, private ServerStats $stats, private ServiceManager $serviceManager, private DiagnosticsProvider $diagnosticProvider, private array $statusProviders)
    {
    }
    public function methods() : array
    {
        return [self::METHOD_DEBUG_CONFIG => 'dumpConfig', self::METHOD_DEBUG_WORKSPACE => 'dumpWorkspace', self::METHOD_DEBUG_STATUS => 'status'];
    }
    /**
     * @return Promise<null|string>
     */
    public function dumpConfig(bool $return = \false) : Promise
    {
        $message = ['Config Dump', '===========', '', 'File Paths', '----------', ''];
        $paths = [];
        foreach ($this->container->get(FilePathResolverExtension::SERVICE_EXPANDERS)->toArray() as $tokenName => $value) {
            $message[] = \sprintf('%s: %s', $tokenName, $value);
        }
        $message[] = '';
        $message[] = 'Config';
        $message[] = '------';
        $json = (string) \json_encode($this->container->getParameters(), \JSON_PRETTY_PRINT);
        $message[] = $json;
        if ($return) {
            return new Success($json);
        }
        $this->client->window()->logMessage()->info(\implode(\PHP_EOL, $message));
        return new Success(null);
    }
    /**
     * @return Promise<null>
     */
    public function dumpWorkspace() : Promise
    {
        $info = [];
        foreach ($this->workspace as $document) {
            \assert($document instanceof TextDocumentItem);
            $info[] = \sprintf('// %s', $document->uri);
            $info[] = '-----------------';
            $info[] = $document->text;
        }
        $this->client->window()->logMessage()->info(\implode("\n", $info));
        return new Success(null);
    }
    /**
     * @return Promise<string>
     */
    public function status() : Promise
    {
        $info = [
            'Process',
            '-------',
            '',
            '  cwd:' . \getcwd(),
            '  pid: ' . \getmypid(),
            '  up: ' . $this->stats->uptime()->format('%ad %hh %im %ss'),
            '',
            'Server',
            '------',
            '',
            // '  connections: ' . $this->stats->connectionCount(),
            // '  requests: ' . $this->stats->requestCount(),
            '  mem: ' . \number_format(\memory_get_peak_usage()) . 'b',
            '  documents: ' . $this->workspace->count(),
            '  services: ' . (string) \json_encode($this->serviceManager->runningServices()),
            '  diagnostics: ' . (string) $this->diagnosticProvider->name(),
            '',
            'Paths',
            '-----',
            '',
        ];
        foreach ($this->container->get(FilePathResolverExtension::SERVICE_EXPANDERS)->toArray() as $tokenName => $value) {
            $info[] = \sprintf('  %s: %s', $tokenName, $value);
        }
        $info[] = '';
        foreach ($this->statusProviders as $provider) {
            $info[] = $provider->title();
            $info[] = \str_repeat('-', \mb_strlen($provider->title()));
            $info[] = '';
            foreach ($provider->provide() as $key => $value) {
                $info[] = \sprintf('  %s: %s', $key, $value);
            }
        }
        return new Success(\implode(\PHP_EOL, $info));
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServer\\Handler\\DebugHandler', 'Phpactor\\Extension\\LanguageServer\\Handler\\DebugHandler', \false);