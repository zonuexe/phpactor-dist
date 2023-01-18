<?php

namespace Phpactor202301\Phpactor\LanguageServer\Handler\Workspace;

use Phpactor202301\Phpactor\LanguageServerProtocol\DidChangeWatchedFilesParams;
use Phpactor202301\Phpactor\LanguageServer\Core\Handler\Handler;
use Phpactor202301\Phpactor\LanguageServer\Event\FilesChanged;
use Phpactor202301\Psr\EventDispatcher\EventDispatcherInterface;
class DidChangeWatchedFilesHandler implements Handler
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
    /**
     * {@inheritDoc}
     */
    public function methods() : array
    {
        return ['workspace/didChangeWatchedFiles' => 'didChange'];
    }
    public function didChange(DidChangeWatchedFilesParams $params) : void
    {
        $this->dispatcher->dispatch(new FilesChanged(...$params->changes));
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Handler\\Workspace\\DidChangeWatchedFilesHandler', 'Phpactor\\LanguageServer\\Handler\\Workspace\\DidChangeWatchedFilesHandler', \false);
