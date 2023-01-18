#!/usr/bin/env php
<?php 
namespace Phpactor202301;

use Phpactor202301\Phpactor\LanguageServerProtocol\InitializeParams;
use Phpactor202301\Phpactor\LanguageServer\Adapter\Psr\AggregateEventDispatcher;
use Phpactor202301\Phpactor\LanguageServer\Core\CodeAction\AggregateCodeActionProvider;
use Phpactor202301\Phpactor\LanguageServer\Core\Diagnostics\AggregateDiagnosticsProvider;
use Phpactor202301\Phpactor\LanguageServer\Core\Diagnostics\DiagnosticsEngine;
use Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher\ArgumentResolver\ChainArgumentResolver;
use Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher\ArgumentResolver\LanguageSeverProtocolParamsResolver;
use Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher\ArgumentResolver\PassThroughArgumentResolver;
use Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher\Dispatcher\MiddlewareDispatcher;
use Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher\Factory\ClosureDispatcherFactory;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\HandlerMethodRunner;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\Handlers;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ResponseWatcher\DeferredResponseWatcher;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\RpcClient\JsonRpcClient;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ServerStats;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\Transmitter\MessageTransmitter;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
use Phpactor202301\Phpactor\LanguageServer\Example\CodeAction\SayHelloCodeActionProvider;
use Phpactor202301\Phpactor\LanguageServer\Example\Command\SayHelloCommand;
use Phpactor202301\Phpactor\LanguageServer\Example\Diagnostics\SayHelloDiagnosticsProvider;
use Phpactor202301\Phpactor\LanguageServer\Handler\TextDocument\CodeActionHandler;
use Phpactor202301\Phpactor\LanguageServer\Handler\Workspace\DidChangeWatchedFilesHandler;
use Phpactor202301\Phpactor\LanguageServer\Listener\DidChangeWatchedFilesListener;
use Phpactor202301\Phpactor\LanguageServer\Listener\ServiceListener;
use Phpactor202301\Phpactor\LanguageServer\Core\Service\ServiceManager;
use Phpactor202301\Phpactor\LanguageServer\Core\Service\ServiceProviders;
use Phpactor202301\Phpactor\LanguageServer\Handler\Workspace\CommandHandler;
use Phpactor202301\Phpactor\LanguageServer\Handler\System\ExitHandler;
use Phpactor202301\Phpactor\LanguageServer\Handler\System\ServiceHandler;
use Phpactor202301\Phpactor\LanguageServer\Handler\System\StatsHandler;
use Phpactor202301\Phpactor\LanguageServer\Handler\TextDocument\TextDocumentHandler;
use Phpactor202301\Phpactor\LanguageServer\LanguageServerBuilder;
use Phpactor202301\Phpactor\LanguageServer\Listener\WorkspaceListener;
use Phpactor202301\Phpactor\LanguageServer\Middleware\CancellationMiddleware;
use Phpactor202301\Phpactor\LanguageServer\Middleware\ErrorHandlingMiddleware;
use Phpactor202301\Phpactor\LanguageServer\Middleware\HandlerMiddleware;
use Phpactor202301\Phpactor\LanguageServer\Middleware\InitializeMiddleware;
use Phpactor202301\Phpactor\LanguageServer\Core\Command\CommandDispatcher;
use Phpactor202301\Phpactor\LanguageServer\Middleware\ResponseHandlingMiddleware;
use Phpactor202301\Phpactor\LanguageServer\Service\DiagnosticsService;
use Phpactor202301\Psr\Log\AbstractLogger;
use function Phpactor202301\Safe\fopen;
require __DIR__ . '/../vendor/autoload.php';
if ($argc === 1) {
    echo <<<DOC
Usage: serve.php --address=127.0.0.1:9000 --type=tcp

Parameters:
-a --address
    Address of the server. (needs to be set for a tcp server)
-t --type
    Type of server (optional, default is tcp)
DOC;
    exit(1);
}
$cliOptions = \getopt('t::a::', ['type::', 'address::']);
$type = $cliOptions['t'] ?? $cliOptions['type'] ?? 'tcp';
$address = $cliOptions['a'] ?? $cliOptions['address'] ?? null;
if ($type === 'tcp' && !\is_string($address)) {
    throw new \RuntimeException('Address should be a string');
}
$in = fopen('php://stdin', 'r');
$out = fopen('php://stdout', 'w');
$logger = new class extends AbstractLogger
{
    /** @var resource */
    private $err;
    /** @var resource */
    private $log;
    public function __construct()
    {
        $this->err = fopen('php://stderr', 'w');
        $this->log = fopen('phpactor-lsp.log', 'w');
    }
    public function log($level, $message, array $context = [])
    {
        $message = \json_encode(['level' => $level, 'message' => $message, 'context' => $context]) . \PHP_EOL . \PHP_EOL;
        \fwrite($this->err, $message);
        \fwrite($this->log, $message);
    }
};
$logger->info('test language server starting');
$logger->info('i am a demonstration server and provide no functionality');
$stats = new ServerStats();
$builder = LanguageServerBuilder::create(new ClosureDispatcherFactory(function (MessageTransmitter $transmitter, InitializeParams $params) use($logger, $stats) {
    $responseWatcher = new DeferredResponseWatcher();
    $clientApi = new ClientApi(new JsonRpcClient($transmitter, $responseWatcher));
    $diagnosticsService = new DiagnosticsService(new DiagnosticsEngine($clientApi, new AggregateDiagnosticsProvider($logger, new SayHelloDiagnosticsProvider())));
    $serviceProviders = new ServiceProviders($diagnosticsService);
    $workspace = new Workspace();
    $serviceManager = new ServiceManager($serviceProviders, $logger);
    $eventDispatcher = new AggregateEventDispatcher(new ServiceListener($serviceManager), new WorkspaceListener($workspace), new DidChangeWatchedFilesListener($clientApi, ['**/*.php'], $params->capabilities), $diagnosticsService);
    $handlers = new Handlers(new TextDocumentHandler($eventDispatcher), new StatsHandler($clientApi, $stats), new ServiceHandler($serviceManager, $clientApi), new CommandHandler(new CommandDispatcher(['phpactor.say_hello' => new SayHelloCommand($clientApi)])), new DidChangeWatchedFilesHandler($eventDispatcher), new CodeActionHandler(new AggregateCodeActionProvider(new SayHelloCodeActionProvider()), $workspace), new ExitHandler());
    $runner = new HandlerMethodRunner($handlers, new ChainArgumentResolver(new LanguageSeverProtocolParamsResolver(), new PassThroughArgumentResolver()));
    return new MiddlewareDispatcher(new ErrorHandlingMiddleware($logger), new InitializeMiddleware($handlers, $eventDispatcher, ['version' => 1]), new CancellationMiddleware($runner), new ResponseHandlingMiddleware($responseWatcher), new HandlerMiddleware($runner));
}), $logger);
if ($type === 'tcp') {
    /** @phpstan-ignore-next-line */
    $builder->tcpServer((string) $address);
}
$builder->withServerStats($stats)->build()->run();
