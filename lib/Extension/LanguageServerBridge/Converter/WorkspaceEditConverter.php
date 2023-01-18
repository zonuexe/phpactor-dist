<?php

namespace Phpactor202301\Phpactor\Extension\LanguageServerBridge\Converter;

use Phpactor202301\Phpactor\LanguageServerProtocol\WorkspaceEdit;
use Phpactor202301\Phpactor\TextDocument\TextDocumentLocator;
use Phpactor202301\Phpactor\TextDocument\WorkspaceEdits;
class WorkspaceEditConverter
{
    public function __construct(private TextDocumentLocator $locator)
    {
    }
    public function toLspWorkspaceEdit(WorkspaceEdits $edits) : WorkspaceEdit
    {
        $lspEdits = [];
        foreach ($edits as $edit) {
            $lspEdits[$edit->uri()->__toString()] = TextEditConverter::toLspTextEdits($edit->textEdits(), $this->locator->get($edit->uri())->__toString());
        }
        return new WorkspaceEdit($lspEdits);
    }
}
\class_alias('Phpactor202301\\Phpactor\\Extension\\LanguageServerBridge\\Converter\\WorkspaceEditConverter', 'Phpactor\\Extension\\LanguageServerBridge\\Converter\\WorkspaceEditConverter', \false);
