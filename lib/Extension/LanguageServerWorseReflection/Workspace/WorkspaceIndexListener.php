<?php

namespace Phpactor\Extension\LanguageServerWorseReflection\Workspace;

use Phpactor\LanguageServer\Event\TextDocumentClosed;
use Phpactor\LanguageServer\Event\TextDocumentOpened;
use Phpactor\LanguageServer\Event\TextDocumentUpdated;
use Phpactor\TextDocument\TextDocumentBuilder;
use Phpactor\TextDocument\TextDocumentUri;
use PhpactorDist\Psr\EventDispatcher\ListenerProviderInterface;
class WorkspaceIndexListener implements ListenerProviderInterface
{
    public function __construct(private \Phpactor\Extension\LanguageServerWorseReflection\Workspace\WorkspaceIndex $index)
    {
    }
    public function getListenersForEvent(object $event) : iterable
    {
        if ($event instanceof TextDocumentUpdated) {
            return [[$this, 'updated']];
        }
        if ($event instanceof TextDocumentClosed) {
            return [[$this, 'closed']];
        }
        if ($event instanceof TextDocumentOpened) {
            return [[$this, 'opened']];
        }
        return [];
    }
    public function opened(TextDocumentOpened $opened) : void
    {
        $item = $opened->textDocument();
        $builder = TextDocumentBuilder::create($item->text ?? '');
        if ($item->uri) {
            $builder->uri($item->uri);
        }
        if ($item->languageId) {
            $builder->language($item->languageId);
        }
        $this->index->index($builder->build());
    }
    public function updated(TextDocumentUpdated $updated) : void
    {
        $this->index->update(TextDocumentUri::fromString($updated->identifier()->uri), $updated->updatedText());
    }
    public function closed(TextDocumentClosed $removed) : void
    {
        $this->index->remove(TextDocumentUri::fromString($removed->identifier()->uri));
    }
}
