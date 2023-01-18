<?php

namespace Phpactor202301\Phpactor\LanguageServer\Handler\Workspace;

use Phpactor202301\Amp\Promise;
use Phpactor202301\Phpactor\LanguageServerProtocol\ExecuteCommandOptions;
use Phpactor202301\Phpactor\LanguageServerProtocol\ExecuteCommandParams;
use Phpactor202301\Phpactor\LanguageServerProtocol\ServerCapabilities;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\CanRegisterCapabilities;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\Handler;
use Phpactor202301\Phpactor\LanguageServer\Core\Command\CommandDispatcher;
class CommandHandler implements Handler, CanRegisterCapabilities
{
    /**
     * @var CommandDispatcher
     */
    private $dispatcher;
    public function __construct(CommandDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
    /**
     * {@inheritDoc}
     */
    public function methods() : array
    {
        return ['workspace/executeCommand' => 'executeCommand'];
    }
    /**
     * @return Promise<mixed|null>
     */
    public function executeCommand(ExecuteCommandParams $params) : Promise
    {
        return $this->dispatcher->dispatch($params->command, $params->arguments);
    }
    public function registerCapabiltiies(ServerCapabilities $capabilities) : void
    {
        $capabilities->executeCommandProvider = new ExecuteCommandOptions($this->dispatcher->registeredCommands());
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Handler\\Workspace\\CommandHandler', 'Phpactor\\LanguageServer\\Handler\\Workspace\\CommandHandler', \false);
