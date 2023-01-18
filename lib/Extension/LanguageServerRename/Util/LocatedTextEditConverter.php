<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerRename\Util;

use Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter\TextEditConverter;
use Phpactor202301\Phpactor\Rename\Model\LocatedTextEditsMap;
use Phpactor202301\Phpactor\Rename\Model\RenameResult;
use Phpactor202301\Phpactor\LanguageServerProtocol\RenameFile;
use Phpactor202301\Phpactor\LanguageServerProtocol\TextDocumentEdit;
use Phpactor202301\Phpactor\LanguageServerProtocol\VersionedTextDocumentIdentifier;
use Phpactor202301\Phpactor\LanguageServerProtocol\WorkspaceEdit;
use Phpactor202301\Phpactor\LanguageServer\Core\Workspace\Workspace;
use Phpactor202301\Phpactor\TextDocument\TextDocumentLocator;
final class LocatedTextEditConverter
{
    public function __construct(private Workspace $workspace, private TextDocumentLocator $locator)
    {
    }
    public function toWorkspaceEdit(LocatedTextEditsMap $map, ?RenameResult $renameResult = null) : WorkspaceEdit
    {
        $documentEdits = [];
        foreach ($map->toLocatedTextEdits() as $result) {
            $version = $this->getDocumentVersion((string) $result->documentUri());
            $documentEdits[] = new TextDocumentEdit(new VersionedTextDocumentIdentifier((string) $result->documentUri(), $version), TextEditConverter::toLspTextEdits($result->textEdits(), (string) $this->locator->get($result->documentUri())));
        }
        // deduplicate the edits: with renaming we currently have multiple
        // references to the declaration.
        $documentEdits = \array_map(function (TextDocumentEdit $documentEdit) {
            $new = [];
            foreach ($documentEdit->edits as $edit) {
                $new[\sprintf('%s-%s-%s', $edit->range->start->line, $edit->range->start->character, $edit->newText)] = $edit;
            }
            $documentEdit->edits = \array_values($new);
            return $documentEdit;
        }, $documentEdits);
        if (null !== $renameResult) {
            $documentEdits[] = new RenameFile('rename', $renameResult->oldUri(), $renameResult->newUri());
        }
        return new WorkspaceEdit(null, $documentEdits);
    }
    private function getDocumentVersion(string $uri) : int
    {
        return $this->workspace->has($uri) ? $this->workspace->get($uri)->version : 0;
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerRename\\Util\\LocatedTextEditConverter', 'Phpactor\\Extension\\LanguageServerRename\\Util\\LocatedTextEditConverter', \false);
