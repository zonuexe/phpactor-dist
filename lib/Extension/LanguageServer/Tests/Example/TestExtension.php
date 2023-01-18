<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServer\Tests\Example;

use Phpactor202301\Amp\CancellationToken;
use Phpactor202301\Amp\Promise;
use Phpactor202301\Amp\Success;
use Phpactor202301\Phpactor\LanguageServerProtocol\Command;
use Phpactor202301\Phpactor\LanguageServerProtocol\CodeAction;
use Phpactor202301\Phpactor\LanguageServerProtocol\MessageType;
use Phpactor202301\Phpactor\Container\Container;
use Phpactor202301\Phpactor\Container\ContainerBuilder;
use Phpactor202301\Phpactor\Container\Extension;
use Phpactor202301\Phpactor\Extension\LanguageServer\LanguageServerExtension;
use Phpactor202301\Phpactor\LanguageServerProtocol\Range;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentItem;
use Phpactor202301\Phpactor\LanguageServer\Core\CodeAction\CodeActionProvider;
use Phpactor202301\Phpactor\LanguageServer\Core\Command\Command as CoreCommand;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\Handler;
use Phpactor202301\Phpactor\LanguageServer\Core\Rpc\NotificationMessage;
use Phpactor202301\Phpactor\LanguageServer\Core\Server\ClientApi;
use Phpactor202301\Phpactor\LanguageServer\Core\Service\ServiceProvider;
use Phpactor202301\Phpactor\MapResolver\Resolver;
class TestExtension implements Extension
{
    public function load(ContainerBuilder $container) : void
    {
        $container->register('test.handler', function (Container $container) {
            return new class implements Handler
            {
                public function methods() : array
                {
                    return ['test' => 'test'];
                }
                public function test()
                {
                    return new Success(new NotificationMessage('window/showMessage', ['type' => MessageType::INFO, 'message' => 'Hallo']));
                }
            };
        }, [LanguageServerExtension::TAG_METHOD_HANDLER => []]);
        $container->register('test.service', function (Container $container) {
            return new class($container->get(ClientApi::class)) implements ServiceProvider
            {
                public function __construct(private ClientApi $api)
                {
                }
                public function services() : array
                {
                    return ['test'];
                }
                public function test()
                {
                    $this->api->window()->showmessage()->info('service started');
                    return new Success(new NotificationMessage('window/showMessage', ['type' => MessageType::INFO, 'message' => 'Hallo']));
                }
            };
        }, [LanguageServerExtension::TAG_SERVICE_PROVIDER => []]);
        $container->register('test.command', function (Container $container) {
            return new class implements CoreCommand
            {
                public function __invoke(string $text) : Promise
                {
                    return new Success($text);
                }
            };
        }, [LanguageServerExtension::TAG_COMMAND => ['name' => 'echo']]);
        $container->register('test.code_action_provider', function (Container $container) {
            return new class implements CodeActionProvider
            {
                public function provideActionsFor(TextDocumentItem $textDocument, Range $range, CancellationToken $cancel) : Promise
                {
                    return new Success([CodeAction::fromArray(['title' => 'Alice', 'command' => new Command('Hello Alice', 'phpactor.say_hello', ['Alice'])]), CodeAction::fromArray(['title' => 'Bob', 'command' => new Command('Hello Bob', 'phpactor.say_hello', ['Bob'])])]);
                }
                public function kinds() : array
                {
                    return ['example'];
                }
            };
        }, [LanguageServerExtension::TAG_CODE_ACTION_PROVIDER => []]);
    }
    public function configure(Resolver $schema) : void
    {
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServer\\Tests\\Example\\TestExtension', 'Phpactor\\Extension\\LanguageServer\\Tests\\Example\\TestExtension', \false);
