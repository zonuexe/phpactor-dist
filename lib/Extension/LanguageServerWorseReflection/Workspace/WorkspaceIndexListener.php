<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerWorseReflection\Workspace;

use Phpactor202301\Phpactor\LanguageServer\Event\TextDocumentClosed;
use Phpactor202301\Phpactor\LanguageServer\Event\TextDocumentOpened;
use Phpactor202301\Phpactor\LanguageServer\Event\TextDocumentUpdated;
use Phpactor202301\Phpactor\TextDocument\TextDocumentBuilder;
use Phpactor202301\Phpactor\TextDocument\TextDocumentUri;
use Phpactor202301\Psr\EventDispatcher\ListenerProviderInterface;
class WorkspaceIndexListener implements ListenerProviderInterface
{
    public function __construct(private WorkspaceIndex $index)
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
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerWorseReflection\\Workspace\\WorkspaceIndexListener', 'Phpactor\\Extension\\LanguageServerWorseReflection\\Workspace\\WorkspaceIndexListener', \false);
