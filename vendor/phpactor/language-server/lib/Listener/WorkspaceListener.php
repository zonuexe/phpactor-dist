<?php

namespace Phpactor202301\Phpactor\LanguageServer\Listener;

use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
use Phpactor202301\Phpactor\LanguageServer\Event\TextDocumentClosed;
use Phpactor202301\Phpactor\LanguageServer\Event\TextDocumentOpened;
use Phpactor202301\Phpactor\LanguageServer\Event\TextDocumentUpdated;
use Phpactor202301\Psr\EventDispatcher\ListenerProviderInterface;
class WorkspaceListener implements ListenerProviderInterface
{
    /**
     * @var Workspace
     */
    private $workspace;
    public function __construct(Workspace $workspace)
    {
        $this->workspace = $workspace;
    }
    /**
     * {@inheritDoc}
     */
    public function getListenersForEvent(object $event) : iterable
    {
        if ($event instanceof TextDocumentClosed) {
            (yield function (TextDocumentClosed $closed) : void {
                $this->workspace->remove($closed->identifier());
            });
            return;
        }
        if ($event instanceof TextDocumentOpened) {
            (yield function (TextDocumentOpened $opened) : void {
                $this->workspace->open($opened->textDocument());
            });
            return;
        }
        if ($event instanceof TextDocumentUpdated) {
            (yield function (TextDocumentUpdated $updated) : void {
                $this->workspace->update($updated->identifier(), $updated->updatedText());
            });
            return;
        }
    }
}
\class_alias('Phpactor202301\\Phpactor\\LanguageServer\\Listener\\WorkspaceListener', 'Phpactor\\LanguageServer\\Listener\\WorkspaceListener', \false);
