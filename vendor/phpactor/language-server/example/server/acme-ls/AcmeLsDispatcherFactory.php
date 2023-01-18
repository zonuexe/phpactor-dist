<?php

namespace Phpactor202301\AcmeLs;

use Phpactor202301\Phpactor\LanguageServer\Adapter\Psr\AggregateEventDispatcher;
use Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher\ArgumentResolver\PassThroughArgumentResolver;
use Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher\ArgumentResolver\LanguageSeverProtocolParamsResolver;
use Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher\ArgumentResolver\ChainArgumentResolver;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
use Phpactor202301\Phpactor\LanguageServer\Listener\WorkspaceListener;
use Phpactor202301\Phpactor\LanguageServer\Middleware\CancellationMiddleware;
use Phpactor202301\Phpactor\LanguageServer\Middleware\ErrorHandlingMiddleware;
use Phpactor202301\Phpactor\LanguageServer\Middleware\InitializeMiddleware;
use Phpactor202301\Phpactor\LanguageServerProtocol\InitializeParams;
use Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher\Dispatcher;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\HandlerMethodRunner;
use Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher\DispatcherFactory;
use Phpactor202301\Phpactor\LanguageServer\Handler\System\ExitHandler;
use Phpactor202301\Phpactor\LanguageServer\Handler\Workspace\CommandHandler;
use Phpactor202301\Phpactor\LanguageServer\Middleware\ResponseHandlingMiddleware;
use Phpactor202301\Phpactor\LanguageServer\Core\Command\CommandDispatcher;
use Phpactor202301\Phpactor\LanguageServer\Handler\System\ServiceHandler;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\Handlers;
use Phpactor202301\Phpactor\LanguageServer\Handler\TextDocument\TextDocumentHandler;
use Phpactor202301\Phpactor\LanguageServer\Core\Dispatcher\Dispatcher\MiddlewareDispatcher;
use Phpactor202301\Phpactor\LanguageServer\Listener\ServiceListener;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\RpcClient\JsonRpcClient;
use Phpactor202301\Phpactor\LanguageServer\Core\Service\ServiceManager;
use Phpactor202301\Phpactor\LanguageServer\Core\Service\ServiceProviders;
use Phpactor202301\Phpactor\LanguageServer\Example\Service\PingProvider;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ResponseWatcher\DeferredResponseWatcher;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\Transmitter\MessageTransmitter;
use Phpactor202301\Phpactor\LanguageServer\Middleware\HandlerMiddleware;
use Phpactor202301\Phpactor\LanguageServer\Middleware\ShutdownMiddleware;
use Phpactor202301\Psr\Log\LoggerInterface;
class AcmeLsDispatcherFactory implements DispatcherFactory
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    public function create(MessageTransmitter $transmitter, InitializeParams $initializeParams) : Dispatcher
    {
        $responseWatcher = new DeferredResponseWatcher();
        $clientApi = new ClientApi(new JsonRpcClient($transmitter, $responseWatcher));
        $serviceProviders = new ServiceProviders(new PingProvider($clientApi));
        $serviceManager = new ServiceManager($serviceProviders, $this->logger);
        $workspace = new Workspace();
        $eventDispatcher = new AggregateEventDispatcher(new ServiceListener($serviceManager), new WorkspaceListener($workspace));
        $handlers = new Handlers(new TextDocumentHandler($eventDispatcher), new ServiceHandler($serviceManager, $clientApi), new CommandHandler(new CommandDispatcher([])));
        $runner = new HandlerMethodRunner($handlers, new ChainArgumentResolver(new LanguageSeverProtocolParamsResolver(), new PassThroughArgumentResolver()));
        return new MiddlewareDispatcher(new ErrorHandlingMiddleware($this->logger), new InitializeMiddleware($handlers, $eventDispatcher, ['version' => 1]), new ShutdownMiddleware($eventDispatcher), new ResponseHandlingMiddleware($responseWatcher), new CancellationMiddleware($runner), new HandlerMiddleware($runner));
    }
}
